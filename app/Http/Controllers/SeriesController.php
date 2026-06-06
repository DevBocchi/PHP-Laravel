<?php

namespace App\Http\Controllers;

use App\Models\Serie;
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
        // Array criado para armazenar as séries usando a Class Serie
        $series = Serie::query()->orderBy('nome')->get();
       //dd($series); // dump and die

        $mensagemSucesso = session('mensagem.sucesso');


        /*
         * Retorna a view localizada em resources/views/series/index.blade.php.
         *
         * Notas de estudo:
         * - Diretórios de views: Usa-se o ponto (.) como separador de pastas em vez da barra (/).
         * - Passagem de parâmetros: O método ->with('nomeNaView', $variavelNoController) envia a variável.
         * - Dica: Poderíamos usar o compact() perfeitamente aqui também!
         *   Exemplo: return view('series.index', compact('series'));
         */
        return view('series.index')->with('series', $series)->with('mensagem.sucesso', $mensagemSucesso);
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
        Serie::create($request->all());

        $request->session()->flash('mensagem.sucesso', "Serie, '{$serie->nome}' cadastrado com sucesso!");

        /* codigo a cima é o resumo do codigo abaixo
        @var string $nomeSerie Nome da série extraído do corpo da requisição
        $nomeSerie = $request->input->nome;
        @var Serie $serie Nova instância do model Serie (equivalente a um registro em branco na tabela)
        $serie = new Serie();
        Atribui o nome recebido ao campo 'nome' do model antes de persistir
        $serie->nome = $nomeSerie;
        Gera e executa o INSERT na tabela 'series' com os dados atribuídos
        $serie->save();
        */

        /** Redireciona o usuário para a listagem após salvar com sucesso */
        return to_route('series.index');
    }

    public function destroy(Request $request)
    {
        Serie::destroy($request->series);
        $request->session()->flash('mensagem.sucesso', 'Serie removida com sucesso!');

        return to_route('series.index');
    }
}
