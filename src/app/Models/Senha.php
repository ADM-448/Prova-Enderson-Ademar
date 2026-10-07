<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Senha extends Model
{
    protected $fillable = [
        'codigo',
        'tipo',
        'status',
        'emissao',
        'chamada_em',
    ];

    protected $hidden = ['created_at', 'updated_at', 'id'];
}
