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
    {{-- usando o asset('') e uma boa pratica para caso utilize de outro lugar --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

{{-- Reutiliza a variável $title para o cabeçalho principal (h1) da página --}}
<h1>{{ $title }}</h1>

{{--
    Variável especial do Blade para componentes de layout.
    O $slot injeta dinamicamente todo o conteúdo (HTML ou texto) que for colocado
    entre as tags de abertura e fechamento lá na view que chamou o componente
    (ou seja, tudo que fica entre <x-layout> e </x-layout>).
--}}
{{ $slot }}

</body>
</html>
