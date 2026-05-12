<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- esta recebendo a a variavel do index --}}
    <title>{{ $title }}</title>
</head>
<body>
<h1> {{ $title }}</h1>

    {{-- O uso do $slot é para verificar o que tem dentro da tag <x-layout> --}}
    {{ $slot }}
</body>
</html>
