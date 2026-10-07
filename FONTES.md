# FONTES.md — Declaração de Consultas

> [!IMPORTANT]
> **Consulta é permitida — conteúdo sem rastreabilidade, não.**
> Preencha este arquivo **antes do push final** se você usou qualquer fonte
> além do seu próprio conhecimento e do material deste repositório. Se não
> usou nada, declare isso nas seções abaixo (transparência também conta ponto
> de confiança na correção).[^transparencia]

## 1. Sites / documentação consultados

| # | URL | O que foi consultado | Onde aparece no entregável |
| 1 | https://laravel.com/framework/docs/12.x/controllers | Sintaxe e estrutura de controllers no Laravel | Controllers da aplicação |
| 2 | https://coddy.tech/docs/pt/javascript/async-await | Estrutura de chamadas assíncronas em JavaScript | Frontend / Scripts |
| 3 | https://imasters.com.br/php/como-fazer-um-crud-no-laravel-do-zero-parte-1 | Estruturação e boas práticas de CRUD no Laravel | Models, Migrations e Rotas |


*(Ex.: `https://docs.oracle.com/...` → sintaxe de `Optional` → `plan.md` na
seção de decisões. Esse link é ILUSTRATIVO — fora de linha numerada não
conta. Se nenhum site foi consultado, escreva: **"Nenhum site consultado."**)*

## 2. Uso de IA — **somente como consulta**

> [!WARNING]
> Usar IA **como agente** (ela edita arquivos, executa comandos, roda testes no
> seu lugar) é **proibido** e zera a prova. Usar IA como consulta (perguntas,
> explicações de conceito, revisão pontual, trechos que você copiou e entende) é
> permitido **desde que**:

1. a conversa seja **compartilhada** (botão Share) e o link fique **público**
   (ou acessível ao professor);
2. o link seja registrado abaixo, indicando **onde** o conteúdo foi usado;
3. você seja capaz de **explicar qualquer trecho** que a IA produziu — na
   dúvida, o professor pede o link e pergunta sobre o código.[^plagio]

| # | Link público da conversa | Onde o conteúdo foi usado |
## 2. Uso de IA — somente como consulta

| # | Ferramenta / Link | O que foi consultado | Onde aparece no entregável |
| 1 | Antigravity / Gemini IA | Dúvidas de configuração de Dockerfile, entrypoint com SQLite e Laravel | Dockerfile e Controllers |
| 1 | https://share.gemini.google/wqERUDWw1OmQ | Dúvidas de arquitetura do Containerfile, entrypoint com SQLite e lógica do controller | Containerfile, entrypoint.sh e SenhaController.php |



*(Se nenhuma IA foi utilizada, escreva: **"Nenhuma IA utilizada."**)*

## 3. Compromisso

Declaro que todo o conteúdo deste repositório que não é de minha autoria direta
está declarado acima, e que consigo explicar qualquer trecho entregue — tenha
ele vindo da minha cabeça, de um site ou de uma IA consultada.

**Nome / RA:**
Ademar de Araújo Teisen / 23182969-2

[^transparencia]: Este arquivo é, ele mesmo, um exemplo de markdown bem
    usado: *alert* para a regra crítica, tabelas para os registros e *footnote*
    para justificativas. O mesmo padrão vale para os `.md` que você entregar.
[^plagio]: Rubrica comum da disciplina: conteúdo de LLM não declarado
    configura plágio e zera a prova — o link público da conversa é o que
    transforma "copiou" em "consultou".
