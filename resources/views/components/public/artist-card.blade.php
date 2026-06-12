@props([
    'artista'
])

<article class="group overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] p-5 transition hover:border-violet-400/40 hover:bg-white/[0.05]">
    <div class="mb-16 h-28 rounded-2xl bg-slate-900 overflow-hidden">
        @if($artista->foto_url)
            <img src="{{ $artista->foto_url }}"
                 alt="{{ $artista->nombre }}"
                 class="h-full w-full object-cover opacity-80 transition duration-500 group-hover:scale-105">
        @else
            <div class="h-full w-full bg-[radial-gradient(circle_at_top,_#4c1d95,_#020617_70%)]"></div>
        @endif
    </div>

    <p class="text-xs font-bold uppercase tracking-[0.35em] text-violet-300">
        {{ $artista->genero ?? 'Artista' }}
    </p>

    <h3 class="mt-2 text-lg font-black text-white">
        {{ $artista->nombre }}
    </h3>
</article>