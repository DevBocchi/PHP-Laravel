{{-- a tag x é acompanhada pelo nome da classe, e esta passando o titulo --}}
<x-layout title="Series">
    <ul>
        <!-- foreach - executa os dados da variavel | $series - variavel da classe controller | $serie - variavel do proprio foreach -->
        {{-- Agora sera usado o Blade --}}
        {{-- a Abertura <?php virou @ --}}
        @foreach ($series as $serie)
        <!-- acessa a variavel do foreach-->
        {{-- e o echo virou {{  }} --}}
        <li>{{ $serie }}</li>
        <!-- encerra o foreach-->
        {{-- a Abertura <?php virou @ --}}
        @endforeach
    </ul>

    <h3>Aonde eu parei na Alura: </h3>
    <a> Criando um Layout </a>
</x-layout>
