# Roteiro Guiado — Reconstruindo o Controle de Séries com Laravel

Este roteiro foi montado com base nas aulas que você estudou e no código final do projeto. O objetivo é que você reconstrua o projeto sozinho, passo a passo, entendendo cada decisão. Cada etapa tem: **o que fazer**, **por que fazer** e um **checkpoint** para você validar antes de avançar.

---

## Pré-requisitos

Antes de começar, garanta que você tem instalado:

- PHP 8.1+ (com as extensões: `fileinfo`, `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`)
- Composer
- Node.js e NPM
- Um editor de código (VS Code, PhpStorm, etc.)

---

## ETAPA 1 — Criando o Projeto Laravel

**O que fazer:**
Abra o terminal e rode o comando para criar o projeto:

```bash
composer create-project laravel/laravel controle-series
cd controle-series
```

**Por que:**
O `create-project` baixa o esqueleto do Laravel com toda a estrutura de pastas já organizada, todas as dependências PHP já instaladas e a chave de criptografia já gerada.

**Explore a estrutura:**
Abra o projeto no editor e navegue pelas pastas. Identifique onde ficam:
- Suas classes PHP → `app/`
- Configurações → `config/`
- Banco de dados → `database/`
- Rotas → `routes/`
- Views → `resources/views/`
- Arquivos públicos → `public/`

**Checkpoint:**
Rode `php artisan serve` e acesse `localhost:8000`. Você deve ver a página de boas-vindas do Laravel.

---

## ETAPA 2 — Configurando o Banco de Dados (SQLite)

**O que fazer:**

1. Crie o arquivo do banco de dados:
```bash
touch database/database.sqlite
```

2. Abra o arquivo `.env` na raiz do projeto e altere a linha `DB_CONNECTION`:
```
DB_CONNECTION=sqlite
```
Remova (ou comente) as linhas `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — não são necessárias para SQLite.

**Por que:**
O Laravel usa variáveis de ambiente (`.env`) para não colocar credenciais no código. O SQLite é ideal para estudo porque dispensa um servidor de banco. A configuração padrão em `config/database.php` já aponta para `database/database.sqlite`.

**Checkpoint:**
Rode `php artisan migrate`. As tabelas padrão do Laravel (users, etc.) devem ser criadas sem erros.

---

## ETAPA 3 — Criando a Migration da Tabela Séries

**O que fazer:**

```bash
php artisan make:migration create_series_table
```

Abra o arquivo gerado em `database/migrations/` e edite o método `up`:

```php
public function up()
{
    Schema::create('series', function (Blueprint $table) {
        $table->id();
        $table->string('nome', 128);
        $table->timestamps();
    });
}
```

Rode a migration:
```bash
php artisan migrate
```

**Por que:**
Migrations são o versionamento do banco de dados. Em vez de rodar SQL manualmente, você descreve a estrutura em PHP. Isso permite que qualquer pessoa da equipe reproduza o banco. O `timestamps()` cria as colunas `created_at` e `updated_at` automaticamente.

**Conceito-chave:** Uma migration pode ser desfeita com `php artisan migrate:rollback`.

**Checkpoint:**
Rode `php artisan migrate:status`. A migration `create_series_table` deve aparecer como "Ran" (executada).

---

## ETAPA 4 — Criando a Model Serie (Eloquent ORM)

**O que fazer:**

```bash
php artisan make:model Serie
```

Abra `app/Models/Serie.php` e adicione a propriedade `$fillable`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];
}
```

**Por que:**
O Eloquent ORM segue o padrão Active Record — a mesma classe representa o objeto do domínio, faz consultas e persiste dados. O `$fillable` é uma proteção contra mass assignment: ele define quais campos podem ser preenchidos via `::create()` ou `->fill()`, impedindo que um usuário malicioso envie campos indesejados (como `admin = true`).

**Conceito-chave:** Sem `$fillable`, o `Serie::create($request->all())` dá erro proposital de segurança.

**Checkpoint:**
Rode `php artisan tinker` e teste:
```php
Serie::create(['nome' => 'Teste']);
Serie::all();
```
Deve criar e listar a série sem erros.

---

## ETAPA 5 — Criando o Controller

**O que fazer:**

```bash
php artisan make:controller SeriesController
```

Abra `app/Http/Controllers/SeriesController.php` e crie o primeiro método:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')
            ->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }
}
```

**Não implemente os outros métodos ainda.** Vá etapa por etapa.

**Por que:**
O controller recebe a requisição e devolve uma resposta. Aqui estamos buscando todas as séries ordenadas por nome, lendo uma possível flash message da sessão, e retornando uma view passando os dados com `->with()`.

**Conceito-chave:** `session('mensagem.sucesso')` busca um dado da sessão flash — um dado que dura apenas uma requisição e depois é esquecido automaticamente.

**Checkpoint:**
Ainda sem view, então vamos criá-la na próxima etapa.

---

## ETAPA 6 — Criando o Layout (Componente Blade)

**O que fazer:**

Crie a pasta e o arquivo:
```
resources/views/components/layout.blade.php
```

Conteúdo:

```html
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Controle de Séries</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>{{ $title }}</h1>
    {{ $slot }}
</div>
</body>
</html>
```

**Por que:**
Componentes Blade permitem reutilizar estrutura HTML. O `{{ $title }}` é um atributo que cada view passa. O `{{ $slot }}` é o conteúdo que fica dentro da tag `<x-layout>`. A função `asset()` gera o caminho correto para arquivos na pasta `public/`.

**Conceito-chave:** Componentes anônimos (só view, sem classe PHP) ficam em `resources/views/components/`. Usamos como `<x-layout title="Título">conteúdo</x-layout>`.

**Checkpoint:**
Arquivo criado. Será usado na próxima etapa.

---

## ETAPA 7 — Criando a View de Listagem (index)

**O que fazer:**

Crie a pasta e o arquivo:
```
resources/views/series/index.blade.php
```

Conteúdo:

```html
<x-layout title="Séries">
    <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar</a>

    @isset($mensagemSucesso)
    <div class="alert alert-success">
        {{ $mensagemSucesso }}
    </div>
    @endisset

    <ul class="list-group">
        @foreach ($series as $serie)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $serie->nome }}

            <span class="d-flex">
                <a href="{{ route('series.edit', $serie->id) }}"
                   class="btn btn-primary btn-sm">E</a>

                <form action="{{ route('series.destroy', $serie->id) }}"
                      method="post" class="ms-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">X</button>
                </form>
            </span>
        </li>
        @endforeach
    </ul>
</x-layout>
```

**Por que:**
Aqui vários conceitos se juntam:
- `@isset` → só exibe a div de sucesso se a flash message existir
- `@foreach` → percorre a coleção de séries
- `@csrf` → proteção contra CSRF (cross-site request forgery); obrigatório em todo formulário
- `@method('DELETE')` → HTML só suporta GET e POST; essa diretiva engana o Laravel para tratar como DELETE
- `route('series.destroy', $serie->id)` → gera a URL usando rotas nomeadas, passando o ID como parâmetro

**Conceito-chave:** Para ações destrutivas (deletar), nunca use um link simples (GET). Use sempre um formulário com POST/DELETE, para evitar que crawlers ou acessos acidentais removam dados.

**Checkpoint:**
Ainda falta configurar as rotas. Próxima etapa.

---

## ETAPA 8 — Definindo as Rotas

**O que fazer:**

Abra `routes/web.php` e substitua todo o conteúdo por:

```php
<?php

use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/series');
});

Route::resource('/series', SeriesController::class)
    ->except(['show']);
```

**Por que:**
`Route::resource` cria automaticamente 7 rotas seguindo o padrão RESTful, cada uma com nome e verbo HTTP correto. Usamos `->except(['show'])` porque não temos uma view de detalhes da série. As rotas geradas são:

| Verbo   | URL                  | Action  | Nome Rota       |
|---------|----------------------|---------|-----------------|
| GET     | /series              | index   | series.index    |
| GET     | /series/create       | create  | series.create   |
| POST    | /series              | store   | series.store    |
| GET     | /series/{series}/edit| edit    | series.edit     |
| PUT     | /series/{series}     | update  | series.update   |
| DELETE  | /series/{series}     | destroy | series.destroy  |

**Conceito-chave:** Rotas nomeadas (`series.index`, etc.) permitem que você mude as URLs sem quebrar links nas views, bastando usar `route('nome')`.

**Checkpoint:**
Rode `php artisan route:list`. Deve listar todas as rotas acima. Acesse `localhost:8000` — deve redirecionar para `/series` e mostrar a listagem (vazia por enquanto).

---

## ETAPA 9 — Implementando o Create e Store

**O que fazer:**

Primeiro, crie o componente de formulário reutilizável:
```
resources/views/components/series/form.blade.php
```

```html
<form action="{{ $action }}" method="post">
    @csrf

    @isset($nome)
    @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" id="nome" name="nome" class="form-control"
               @isset($nome)value="{{ $nome }}"@endisset>
    </div>

    <button type="submit" class="btn btn-primary">Adicionar</button>
</form>
```

Depois, crie a view:
```
resources/views/series/create.blade.php
```

```html
<x-layout title="Nova Série">
    <x-series.form :action="route('series.store')" />
</x-layout>
```

E adicione os métodos no controller:

```php
public function create()
{
    return view('series.create');
}

public function store(Request $request)
{
    $serie = Serie::create($request->all());

    return to_route('series.index')
        ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
}
```

**Por que:**
O componente `form.blade.php` é reutilizado tanto para criar quanto para editar. A lógica: se `$nome` existir, é edição (e injeta `@method('PUT')` + preenche o value); se não existir, é criação. O `Serie::create($request->all())` usa mass assignment protegido pelo `$fillable`. O `to_route()` redireciona e o `->with()` cria a flash message.

**Conceito-chave:** Padrão Post-Redirect-Get — após um POST, sempre redirecione com GET. Se o usuário atualizar a página, não reenvia o formulário.

**Checkpoint:**
Acesse `/series/create`, crie uma série e confirme que aparece na listagem com a mensagem de sucesso. Atualize a página e a mensagem deve sumir (flash).

---

## ETAPA 10 — Implementando o Destroy

**O que fazer:**

Adicione ao controller:

```php
public function destroy(Serie $series)
{
    $series->delete();

    return to_route('series.index')
        ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
}
```

**Por que:**
Repare no parâmetro `Serie $series` — o Laravel faz o **Model Binding** automaticamente. Como o parâmetro da rota se chama `{series}` e o tipo é `Serie`, o Laravel busca no banco `SELECT * FROM series WHERE id = {valor}` antes mesmo de entrar no método. Você já recebe o objeto pronto.

**Detalhe importante:** Em inglês, o singular de "series" é "series" (mesmo). Por isso o parâmetro da rota e a variável ficam com o mesmo nome. Se sua rota fosse `/filmes`, o parâmetro seria `{filme}`.

**Checkpoint:**
Clique no botão "X" ao lado de uma série. Ela deve ser removida e a mensagem de sucesso deve aparecer.

---

## ETAPA 11 — Implementando o Edit e Update

**O que fazer:**

Crie a view:
```
resources/views/series/edit.blade.php
```

```html
<x-layout title="Editar Série '{{ $serie->nome }}'">
    <x-series.form :action="route('series.update', $serie->id)" :nome="$serie->nome" />
</x-layout>
```

Adicione ao controller:

```php
public function edit(Serie $series)
{
    return view('series.edit')->with('serie', $series);
}

public function update(Serie $series, Request $request)
{
    $series->fill($request->all());
    $series->save();

    return to_route('series.index')
        ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
}
```

**Por que:**
O `->fill()` preenche os atributos protegidos pelo `$fillable` sem salvar. O `->save()` persiste no banco. Alternativa: `$series->nome = $request->nome; $series->save();` — faz a mesma coisa campo a campo.

**Checkpoint:**
Clique no "E" ao lado de uma série, altere o nome, salve. A listagem deve mostrar o nome atualizado com a mensagem de sucesso.

---

## ETAPA 12 — Instalando o Bootstrap (Front-end)

**O que fazer:**

```bash
npm install
npm install bootstrap --save
npm install laravel-mix sass sass-loader resolve-url-loader --save-dev
```

Crie (ou edite) o arquivo `webpack.mix.js` na raiz:

```js
const mix = require('laravel-mix');

mix.sass('resources/css/app.scss', 'public/css');
```

Renomeie `resources/css/app.css` para `resources/css/app.scss` e coloque:

```scss
@import "~bootstrap/scss/bootstrap";
```

Compile:

```bash
npx mix
```

**Por que:**
O Laravel Mix simplifica a configuração do Webpack. Em vez de arquivos de configuração enormes, uma linha faz: pegar o SCSS, compilar o Bootstrap para CSS e jogar em `public/css/`. Seu layout já referencia `asset('css/app.css')`, então o estilo é aplicado automaticamente.

**Nota:** Versões mais novas do Laravel usam Vite em vez do Mix. O conceito é o mesmo, só muda a ferramenta.

**Checkpoint:**
Acesse `localhost:8000/series`. A página deve ter os estilos do Bootstrap aplicados (botões coloridos, listas estilizadas, container centralizado).

---

## ETAPA 13 (BÔNUS) — Validação (início)

O curso começa a abordar validação no final. Adicione no seu método `store`:

```php
$request->validate([
    'nome' => ['required', 'min:3'],
]);
```

Coloque **antes** do `Serie::create()`. Se a validação falhar, o Laravel redireciona automaticamente de volta ao formulário. Faça o mesmo no `update`.

**Checkpoint:**
Tente criar uma série com nome vazio ou com menos de 3 caracteres. O formulário deve recarregar sem inserir nada.

---

## Resumo Visual do Fluxo MVC

```
Usuário acessa /series (GET)
    → routes/web.php encontra a rota
    → SeriesController@index é chamado
    → Busca séries no banco via Eloquent (Serie::query()...)
    → Retorna view('series.index') com os dados
    → Blade renderiza o HTML usando o layout
    → Resposta HTML volta ao navegadorn

Usuário envia formulário (POST /series)
    → routes/web.php encontra a rota
    → Middleware verifica token CSRF
    → SeriesController@store é chamado
    → Valida os dados do request
    → Serie::create() insere no banco
    → Redireciona (to_route) com flash message
    → Navegador faz nova requisição GET para /series
    → index exibe a lista + mensagem de sucesso
```

---

## Dicas para Ir Além

1. **Implemente a validação completa** — exiba os erros na view usando `@error('nome')` e mantenha o input preenchido com `old('nome')`
2. **Adicione mais campos** — sinopse, gênero, nota. Pratique migrations, fillable e formulários
3. **Crie a view show** — remova o `except(['show'])` e implemente a visualização individual
4. **Tente sem consultar** — depois de fazer uma vez com esse roteiro, apague tudo e tente de memória. O que você não lembrar, é o que precisa revisar

---

*Roteiro baseado no curso "Laravel: criando uma aplicação com MVC" + "Laravel: validando formulários, usando sessões e definindo relacionamentos" — Alura*
