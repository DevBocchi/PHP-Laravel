<?php

use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// rota criada para informada para onde vai ser enviado,
//Route - rota | get - pegar | '/series' - pagina de acesso | SeriesController - classe | index - nome da função
Route::get('/series', [SeriesController::class, 'index']);

// Nova rota criada para adicionar nova serie
Route::get('/series/criar', [SeriesController::class, 'create']);
