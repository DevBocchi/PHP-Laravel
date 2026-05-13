<?php

use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você registra as rotas web para a sua aplicação.
|
*/

// Rota padrão do Laravel (página inicial)
Route::get('/', function () {
    return view('welcome');
});

/*
 * Rota para listar as séries.
 *
 * Estrutura de estudo: Route::verbo_http('url', [ClasseController::class, 'metodo']);
 *
 * - get: Método HTTP utilizado para buscar/ler dados.
 * - '/series': O caminho (URL) acessado no navegador.
 * - SeriesController::class: O Controller responsável por processar a requisição.
 * - 'index': A função dentro do Controller que será executada.
 */
Route::get('/series', [SeriesController::class, 'index']);

/*
 * Rota para exibir o formulário de criação de uma nova série.
 *
 * Direciona requisições da URL '/series/criar' para o método 'create' do SeriesController.
 */
Route::get('/series/criar', [SeriesController::class, 'create']);
