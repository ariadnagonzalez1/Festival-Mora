@props([
    'evento'
])

@php
    $precioDesde = $evento->tiposEntradas
        ->where('activo', true)
        ->where('venta_online', true)
        ->min('precio');
@endphp

<article class="group overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03] transition hover:-translate-y-1 hover:border-violet-400/40 hover:bg-white/[0.05]">
    <div class="relative h-64 overflow-hidden bg-slate-900">
        @if($evento->imagen_url)
            <img src="{{ $evento->imagen_url }}"
                 alt="{{ $evento->titulo }}"
                 class="h-full w-full object-cover opacity-70 transition duration-500 group-hover:scale-105">
        @else
            <div class="h-full w-full bg-[radial-gradient(circle_at_top,_#6d28d9,_#020617_65%)]"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-[#050512] via-[#050512]/40 to-transparent"></div>

        <span class="absolute left-4 top-4 rounded-full border border-white/20 bg-black/40 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-white backdrop-blur">
            {{ $evento->ciudad ?? 'Evento' }}
        </span>
    </div>

    <div class="space-y-4 p-6">
        <h3 class="text-xl font-black text-white">
            {{ $evento->titulo }}
        </h3>

        <div class="space-y-2 text-sm text-slate-400">
            <p>
                {{ $evento->fecha_inicio?->translatedFormat('l, d \d\e F \d\e Y · H:i') }}
            </p>
            <p>
                {{ $evento->lugar }}
            </p>
        </div>

        <div class="flex items-end justify-between gap-4 pt-4">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.35em] text-slate-500">
                    Desde
                </p>

                <p class="mt-1 text-2xl font-black text-violet-400">
                    @if($precioDesde)
                        $ {{ number_format($precioDesde, 0, ',', '.') }}
                    @else
                        Consultar
                    @endif
                </p>
            </div>

            <a href="{{ Route::has('register') ? route('register') : '#' }}"
               class="rounded-xl bg-violet-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-violet-500">
                Ver entradas
            </a>
        </div>
    </div>
</article>