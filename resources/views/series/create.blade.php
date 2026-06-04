{{-- Adiciona nova serie --}}
<x-layout title="Nova Serie">
    <form action="{{ route('series.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control">
        </div>

        <button type="submit" class="btn btn-dark mb-2">Adicionar</button>
    </form>
</x-layout>
