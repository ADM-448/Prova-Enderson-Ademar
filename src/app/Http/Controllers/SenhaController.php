<?php

namespace App\Http\Controllers;

use App\Models\Senha;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SenhaController extends Controller
{
    const PREFIXO = 'B';
    const RAZAO_PREFERENCIAL = 3;

    private function formatarSenha(Senha $senha)
    {
        $dados = [
            'codigo' => $senha->codigo,
            'tipo' => $senha->tipo,
            'emissao' => Carbon::parse($senha->emissao)->setTimezone('America/Sao_Paulo')->toIso8601String(),
            'status' => $senha->status,
        ];

        if ($senha->chamada_em) {
            $dados['chamada_em'] = Carbon::parse($senha->chamada_em)->setTimezone('America/Sao_Paulo')->toIso8601String();
        }

        return $dados;
    }

    public function emitir(Request $request)
    {
        $tipo = $request->input('tipo');

        if (!$tipo || !in_array($tipo, ['normal', 'preferencial'])) {
            return response()->json(['erro' => 'tipo_invalido'], 422);
        }

        $senha = DB::transaction(function () use ($tipo) {
            $hoje = Carbon::now('America/Sao_Paulo')->startOfDay();
            $totalHoje = Senha::where('created_at', '>=', $hoje)->count();
            $proximoNumero = $totalHoje + 1;
            $codigo = self::PREFIXO . str_pad($proximoNumero, 3, '0', STR_PAD_LEFT);

            return Senha::create([
                'codigo' => $codigo,
                'tipo' => $tipo,
                'status' => 'aguardando',
                'emissao' => Carbon::now('America/Sao_Paulo'),
            ]);
        });

        return response()->json($this->formatarSenha($senha), 201);
    }

    public function proxima()
    {
        return DB::transaction(function () {
            $ultimasChamadas = Senha::whereNotNull('chamada_em')
                ->orderBy('chamada_em', 'desc')
                ->orderBy('id', 'desc')
                ->take(self::RAZAO_PREFERENCIAL + 1)
                ->get();

            $preferenciaisSeguidas = 0;
            foreach ($ultimasChamadas as $ch) {
                if ($ch->tipo === 'preferencial') {
                    $preferenciaisSeguidas++;
                } else {
                    break;
                }
            }

            $proxima = null;

            if ($preferenciaisSeguidas >= self::RAZAO_PREFERENCIAL) {
                $proxima = Senha::where('status', 'aguardando')
                    ->where('tipo', 'normal')
                    ->orderBy('id', 'asc')
                    ->first();

                if (!$proxima) {
                    $proxima = Senha::where('status', 'aguardando')
                        ->where('tipo', 'preferencial')
                        ->orderBy('id', 'asc')
                        ->first();
                }
            } else {
                $proxima = Senha::where('status', 'aguardando')
                    ->where('tipo', 'preferencial')
                    ->orderBy('id', 'asc')
                    ->first();

                if (!$proxima) {
                    $proxima = Senha::where('status', 'aguardando')
                        ->where('tipo', 'normal')
                        ->orderBy('id', 'asc')
                        ->first();
                }
            }

            if (!$proxima) {
                return response()->json(['erro' => 'fila_vazia'], 404);
            }

            $proxima->status = 'chamada';
            $proxima->chamada_em = Carbon::now('America/Sao_Paulo');
            $proxima->save();

            return response()->json($this->formatarSenha($proxima), 200);
        });
    }

    public function concluir($codigo)
    {
        $senha = Senha::where('codigo', $codigo)->first();

        if (!$senha) {
            return response()->json(['erro' => 'senha_nao_encontrada'], 404);
        }

        if ($senha->status !== 'chamada') {
            return response()->json(['erro' => 'senha_nao_chamada'], 409);
        }

        $senha->status = 'concluida';
        $senha->save();

        return response()->json($this->formatarSenha($senha), 200);
    }

    public function rechamar($codigo)
    {
        $senha = Senha::where('codigo', $codigo)->first();

        if (!$senha) {
            return response()->json(['erro' => 'senha_nao_encontrada'], 404);
        }

        if ($senha->status !== 'chamada') {
            return response()->json(['erro' => 'senha_nao_chamada'], 409);
        }

        $senha->chamada_em = Carbon::now('America/Sao_Paulo');
        $senha->save();

        return response()->json($this->formatarSenha($senha), 200);
    }

    public function cancelar($codigo)
    {
        $senha = Senha::where('codigo', $codigo)->first();

        if (!$senha) {
            return response()->json(['erro' => 'senha_nao_encontrada'], 404);
        }

        if ($senha->status !== 'aguardando') {
            return response()->json(['erro' => 'senha_nao_aguardando'], 409);
        }

        $senha->status = 'cancelada';
        $senha->save();

        return response()->json($this->formatarSenha($senha), 200);
    }

    public function painel()
    {
        $chamadas = Senha::whereNotNull('chamada_em')
            ->orderBy('chamada_em', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get()
            ->map(function ($s) {
                return $this->formatarSenha($s);
            });

        return response()->json(['chamadas' => $chamadas], 200);
    }
}
