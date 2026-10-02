@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">{{ $evento->titulo }}</h1>
        @if($evento->descricao)
            <p class="mt-2 text-gray-400">{{ $evento->descricao }}</p>
        @endif
    </div>

    <div class="grid gap-8 lg:grid-cols-5">
        {{-- Formulário de envio de Pergunta --}}
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-700 bg-gray-800 p-6 shadow-lg">
                <h2 class="mb-5 text-xl font-bold text-white">💬 Faça sua Pergunta</h2>

                <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                    @csrf

                    <div>
                        <label for="texto" class="mb-2 block text-sm font-medium text-gray-300">
                            Texto da Pergunta
                        </label>

                        <textarea
                            name="texto"
                            id="texto"
                            rows="5"
                            class="block w-full rounded-lg border bg-gray-900 p-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('texto') border-red-500 @else border-gray-600 @enderror"
                            placeholder="Digite sua dúvida ou comentário para o palestrante...">{{ old('texto') }}</textarea>

                        @error('texto')
                            <p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-4 w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Enviar Pergunta
                    </button>
                </form>
            </div>
        </div>

        {{-- Lista de Perguntas --}}
        <div class="lg:col-span-3">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white">📋 Perguntas do Evento</h2>
                <span class="text-sm text-gray-400">Total: {{ $perguntas->total() }}</span>
            </div>

            <div class="space-y-4">
                @forelse($perguntas as $pergunta)
                    <div class="rounded-xl rounded-tl-sm border border-gray-700 bg-gray-800 p-5 shadow-md">
                        <p class="break-words text-base leading-relaxed text-white">{{ $pergunta->texto }}</p>

                        <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-gray-700 pt-3 text-sm text-gray-400">
                            <span>Autor: {{ $pergunta->user->name ?? 'Anônimo' }}</span>
                            <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-gray-700 bg-gray-800 p-6 text-center text-gray-400">
                        Nenhuma pergunta enviada ainda. Seja o primeiro!
                    </div>
                @endforelse
            </div>

            @if(method_exists($perguntas, 'links'))
                <div class="mt-6">
                    {{ $perguntas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
