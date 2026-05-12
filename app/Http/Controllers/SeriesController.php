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
       /* o / no Blade para separação é o . */
       return view('series.index')->with('series', $series);
           /* com o uso do Blade, se utiliza outro metodo ao inves do compact()
              se usiliza ->with()*/
           /* compact faz a mesma coisa, so que de forma compacta */
           /* 'series' - variavel criado na view/`listar-series` | $series - variavel criada no `SeriesController`*/

   }

}
