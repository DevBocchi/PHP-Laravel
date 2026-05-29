<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--
        Imprime o valor do atributo 'title' passado na tag do componente.
        Exemplo: ao usar <x-layout title="Series">, a variável $title recebe "Series".
    --}}
    <title>{{ $title }}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    {{-- Reutiliza a variável $title para o cabeçalho principal (h1) da página --}}
    <h1>{{ $title }}</h1>

    {{--
        Variável especial do Blade para componentes de layout.
        O $slot injeta dinamicamente todo o conteúdo (HTML ou texto) que for colocado
        entre as tags de abertura e fechamento lá na view que chamou o componente
        (ou seja, tudo que fica entre <x-layout> e </x-layout>).
    --}}
    {{ $slot }}
</div>
</body>
</html>
