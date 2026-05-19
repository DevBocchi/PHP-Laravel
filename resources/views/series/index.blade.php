{{-- Renderiza o componente de layout padrão (x-layout) passando "Series" como título --}}
<x-layout title="Series">

    {{-- Link que direciona o usuário para o formulário de criação de uma nova série --}}
    <a href="/series/criar">Adicionar</a>

    <ul>
        {{--
            Itera sobre a coleção $series enviada pelo Controller.
            Nota de estudo: No Blade, diretivas começam com '@', substituindo o "<?php foreach"
        --}}
        @foreach ($series as $serie)

            {{--
                Imprime a variável atual do loop.
                Nota de estudo: A sintaxe {{ }} substitui o "<?php echo" e já protege contra XSS
            --}}
            <li>{{ $serie }}</li>

        @endforeach
    </ul>

    {{-- Marcador de progresso do curso --}}
    <h3>Aonde eu parei na Alura: </h3>
    <a> Laravel Mix - Instalando o Bootstrap </a>

</x-layout>
