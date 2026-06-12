@props([
    'evento',
    'align' => 'left'
])

<article class="relative">
    <div class="rounded-[2rem] border border-white/10 bg-white/[0.03] p-4 transition hover:border-violet-400/40 hover:bg-white/[0.05]">
        <div class="relative h-72 overflow-hidden rounded-[1.5rem] bg-slate-900">
            @if($evento->imagen_url)
                <img
                    src="{{ $evento->imagen_url }}"
                    alt="{{ $evento->titulo }}"
                    class="h-full w-full object-cover opacity-70 transition duration-500 hover:scale-105"
                >
            @else
                <div class="h-full w-full bg-[radial-gradient(circle_at_top,_#6d28d9,_#020617_70%)]"></div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-[#050512] via-[#050512]/35 to-transparent"></div>

            <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                <span class="rounded-full border border-white/20 bg-black/40 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-white backdrop-blur">
                    {{ $evento->ciudad ?? 'Mora' }}
                </span>

                <span class="rounded-full bg-violet-500 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-white">
                    Finalizado
                </span>
            </div>

            <span class="absolute right-4 bottom-4 rounded-full border border-white/10 bg-black/45 px-4 py-2 text-xs font-bold text-white backdrop-blur">
                {{ $evento->fecha_inicio?->format('Y') }}
            </span>
        </div>

        <div class="p-5">
            <h3 class="text-2xl font-black text-white">
                {{ $evento->titulo }}
            </h3>

            <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-400">
                <span>
                    {{ $evento->fecha_inicio?->translatedFormat('l, d \d\e F \d\e Y') }}
                </span>

                @if($evento->lugar)
                    <span>
                        {{ $evento->lugar }}
                    </span>
                @endif

                @if($evento->artistas->count())
                    <span>
                        {{ $evento->artistas->count() }} artistas
                    </span>
                @endif
            </div>

            @if($evento->descripcion)
                <p class="mt-5 line-clamp-3 text-sm leading-7 text-slate-400">
                    {{ $evento->descripcion }}
                </p>
            @endif

            @if($evento->artistas->count())
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach($evento->artistas->take(4) as $artista)
                        <span class="rounded-full border border-violet-400/20 bg-violet-500/10 px-3 py-1 text-xs font-medium text-violet-300">
                            {{ $artista->nombre }}
                        </span>
                    @endforeach
                </div>
            @endif

            <button
                type="button"
                class="mt-6 rounded-xl border border-violet-400/30 px-5 py-3 text-sm font-bold text-violet-300 transition hover:bg-violet-500/10"
            >
                Reviví la experiencia →
            </button>
        </div>
    </div>
</article>