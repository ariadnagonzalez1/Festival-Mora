<div class="bg-[#050512] text-white">

    {{-- HERO --}}
    <section class="relative min-h-screen overflow-hidden px-4 pt-28 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(124,58,237,0.22),transparent_30%),radial-gradient(circle_at_80%_30%,rgba(59,130,246,0.15),transparent_30%)]"></div>

        <div class="absolute inset-x-0 top-16 h-[560px] opacity-30">
            @if($bannerEvento?->imagen_url)
                <img src="{{ $bannerEvento->imagen_url }}"
                     alt="{{ $bannerEvento->titulo }}"
                     class="h-full w-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-[#050512] via-[#050512]/90 to-[#050512]"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#050512] via-transparent to-[#050512]/80"></div>
        </div>

        <div class="relative mx-auto flex min-h-[calc(100vh-7rem)] max-w-7xl items-center">
            <div class="max-w-3xl">

                <div class="mb-8 inline-flex items-center rounded-full border border-violet-400/40 bg-violet-500/10 px-5 py-2">
                    <span class="text-xs font-bold uppercase tracking-[0.45em] text-violet-300">
                        Evento destacado
                    </span>
                </div>

                @if($bannerEvento)
                    <h1 class="text-5xl font-black leading-none tracking-tight text-violet-500 sm:text-6xl lg:text-7xl">
                        {{ $bannerEvento->titulo }}
                    </h1>

                    <p class="mt-8 max-w-xl text-lg leading-8 text-slate-300">
                        {{ $bannerEvento->descripcion }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-5 text-sm text-slate-300">
                        <span>{{ $bannerEvento->fecha_inicio?->translatedFormat('l, d \d\e F \d\e Y') }}</span>
                        <span>{{ $bannerEvento->lugar }}, {{ $bannerEvento->ciudad }}</span>
                    </div>
                @else
                    <h1 class="text-5xl font-black leading-none tracking-tight text-violet-500 sm:text-6xl lg:text-7xl">
                        Mora Producciones
                    </h1>

                    <p class="mt-8 max-w-xl text-lg leading-8 text-slate-300">
                        Próximamente vas a poder ver los eventos destacados de Mora Producciones.
                    </p>
                @endif

                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}"
                       class="inline-flex items-center justify-center rounded-xl bg-violet-600 px-8 py-4 text-sm font-black text-white transition hover:bg-violet-500">
                        Comprar entradas
                    </a>

                    <a href="{{ route('public.eventos') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/[0.03] px-8 py-4 text-sm font-black text-white transition hover:bg-white/[0.08]">
                        Ver todos los eventos →
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- PRÓXIMOS EVENTOS --}}
    <section class="px-4 py-20 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12 flex items-end justify-between gap-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                        Agenda
                    </p>

                    <h2 class="mt-4 text-4xl font-black text-white">
                        Próximos eventos
                    </h2>
                </div>

                <a href="{{ route('public.eventos') }}" class="hidden text-sm font-bold text-violet-300 hover:text-violet-200 sm:block">
                    Ver todos →
                </a>
            </div>

            @if($proximosEventos->count())
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($proximosEventos as $evento)
                        <x-public.event-card :evento="$evento" />
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-10 text-center">
                    <p class="text-slate-400">
                        Todavía no hay eventos publicados.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- ARTISTAS DESTACADOS --}}
    <section class="px-4 py-20 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-12">
                <p class="text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                    Line-up
                </p>

                <h2 class="mt-4 text-4xl font-black text-white">
                    Artistas destacados
                </h2>
            </div>

            @if($artistasDestacados->count())
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                    @foreach($artistasDestacados as $artista)
                        <x-public.artist-card :artista="$artista" />
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-10 text-center">
                    <p class="text-slate-400">
                        Todavía no hay artistas destacados cargados.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="px-4 py-20 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-[2rem] border border-violet-400/20 bg-violet-600/15 px-6 py-20 text-center shadow-2xl shadow-violet-950/30">
                <h2 class="text-4xl font-black tracking-tight text-white sm:text-5xl">
                    Viví la experiencia Mora
                </h2>

                <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                    Sumate a la comunidad y recibí los lanzamientos de entradas antes que nadie.
                </p>

                <div class="mt-8">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}"
                       class="inline-flex rounded-xl bg-violet-500 px-8 py-4 text-sm font-black text-white transition hover:bg-violet-400">
                        Crear mi cuenta
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>