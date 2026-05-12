<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series</title>
</head>
<body>
<h1>Series</h1>
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

    <a>Alura - Conhecendo o Blade</a>
</ul>
</body>
</html>
