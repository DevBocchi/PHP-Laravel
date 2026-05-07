<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
   public function index(Request $request)
   {
       /* variavel criada para salvar senhas e chamado pelo `lista-series` */
       $series = [
           'Phineas and Ferb',
           'Avatar',
           'The Mentalist'
       ];

       /* retorna a view para o `listar-series`*/
       return view('listar-series', [
           /* 'series' - variavel criado na view/`listar-series` | $series - variavel criada no `SeriesController`*/
           'series' => $series
       ]);
   }

}
