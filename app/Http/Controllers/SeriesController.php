<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class SeriesController extends Controller
{
    /**
     * Exibe a lista de séries.
     */
    public function index(Request $request)
    {
        // Array criado para armazenar as séries (dados estáticos por enquanto)
        $series = DB::select('SELECT nome FROM series;');
       //dd($series); // dump and die

        /*
         * Retorna a view localizada em resources/views/series/index.blade.php.
         *
         * Notas de estudo:
         * - Diretórios de views: Usa-se o ponto (.) como separador de pastas em vez da barra (/).
         * - Passagem de parâmetros: O método ->with('nomeNaView', $variavelNoController) envia a variável.
         * - Dica: Poderíamos usar o compact() perfeitamente aqui também!
         *   Exemplo: return view('series.index', compact('series'));
         */
        return view('series.index')->with('series', $series);
    }

    /**
     * Exibe o formulário para adicionar uma nova série.
     */
    public function create(Request $request)
    {
        /*
         * Retorna a view do formulário (resources/views/series/create.blade.php).
         * Lembrando que 'series.create' aponta para a pasta 'series' e o arquivo 'create'.
         */
        return view('series.create');
    }

    public function store(Request $request)
    {
        $nomeSerie = $request->input('nome');

        if(DB::insert('INSERT INTO series (nome) VALUES (?)', [$nomeSerie])) {
            return "OK";
        } else {
            return "ERRO";
        }
    }
}
