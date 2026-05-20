{{-- Renderiza o componente de layout padrão (x-layout) passando "Series" como título --}}
<x-layout title="Series">

    {{-- Link que direciona o usuário para o formulário de criação de uma nova série --}}
    <a href="/series/criar" class="btn btn-dark mb-2">Adicionar</a>

    {{-- list-group é o container da lista. Aplicado em uma <ul> ou <div>, define o agrupamento visual. --}}
    <ul class="list-group">
        {{--
            Itera sobre a coleção $series enviada pelo Controller.
            Nota de estudo: No Blade, diretivas começam com '@', substituindo o "<?php foreach"
        --}}
        @foreach ($series as $serie)

            {{--
                Imprime a variável atual do loop.
                Nota de estudo: A sintaxe {{ }} substitui o "<?php echo" e já protege contra XSS
            --}}
            {{-- list-group-item é cada item da lista. Aplicado em <li> ou <a>, estiliza cada entrada individualmente. --}}
            <li class="list-group-item">{{ $serie }}</li>

        @endforeach
    </ul>

    {{-- Marcador de progresso do curso --}}
    <h3>Aonde eu parei na Alura: </h3>
    <a> Models - DB Facade</a>

</x-layout>
