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
                    @if($bannerEvento)
                        <button
                            type="button"
                            wire:click="abrirEntradas({{ $bannerEvento->id }})"
                            class="inline-flex items-center justify-center rounded-xl bg-violet-600 px-8 py-4 text-sm font-black text-white transition hover:bg-violet-500"
                        >
                            Comprar entradas
                        </button>
                    @else
                        <a href="{{ route('public.eventos') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-violet-600 px-8 py-4 text-sm font-black text-white transition hover:bg-violet-500">
                            Ver eventos
                        </a>
                    @endif

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

    {{-- MODAL ENTRADAS --}}
    @if($mostrarModalEntradas && $eventoSeleccionado)
        @php
            $puedeVerQr = auth()->check() && auth()->user()->esUsuario();
        @endphp

        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/80 px-4 py-6 backdrop-blur-sm">
            <div class="relative max-h-[90vh] w-full max-w-6xl overflow-y-auto rounded-3xl border border-white/10 bg-[#080b1d] p-6 shadow-2xl">

                {{-- CERRAR --}}
                <button
                    type="button"
                    wire:click="cerrarEntradas"
                    class="absolute right-5 top-5 text-2xl text-slate-400 transition hover:text-white"
                >
                    ×
                </button>

                {{-- HEADER MODAL --}}
                <div class="pr-10">
                    <h2 class="text-2xl font-black text-white">
                        Entradas —
                        <span class="text-violet-400">
                            {{ $eventoSeleccionado->titulo }}
                        </span>
                    </h2>

                    <p class="mt-2 text-sm text-slate-400">
                        Elegí tu tipo de entrada. Los QR de pago solo se muestran a usuarios con sesión iniciada.
                    </p>

                    @guest
                        <div class="mt-4 rounded-2xl border border-yellow-400/30 bg-yellow-400/10 p-4 text-sm text-yellow-100">
                            Para ver los QR de pago y comprar entradas, primero tenés que iniciar sesión.
                            <a href="{{ route('login') }}" class="font-black text-yellow-300 underline">
                                Iniciar sesión
                            </a>
                        </div>
                    @endguest

                    @auth
                        @if(! auth()->user()->esUsuario())
                            <div class="mt-4 rounded-2xl border border-blue-400/30 bg-blue-400/10 p-4 text-sm text-blue-100">
                                Estás ingresando como administrador. El administrador no compra entradas.
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- CARDS ENTRADAS --}}
                <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($eventoSeleccionado->tiposEntradas as $tipo)
                        @php
                            $nombreLower = strtolower($tipo->nombre);
                            $esVipOro = str_contains($nombreLower, 'oro');
                        @endphp

                        <div
                            class="rounded-3xl border p-5
                            {{ $esVipOro
                                ? 'border-yellow-400/50 bg-yellow-400/[0.03]'
                                : 'border-violet-400/30 bg-white/[0.03]'
                            }}"
                        >
                            <div class="flex items-center justify-between">
                                <span
                                    class="rounded-full border px-3 py-1 text-[11px] font-black uppercase tracking-widest
                                    {{ $esVipOro
                                        ? 'border-yellow-400/60 text-yellow-300'
                                        : 'border-violet-400/60 text-violet-300'
                                    }}"
                                >
                                    {{ $esVipOro ? 'Premium' : $tipo->nombre }}
                                </span>

                                <span class="text-lg {{ $esVipOro ? 'text-yellow-300' : 'text-violet-300' }}">
                                    {{ $tipo->venta_online ? '▦' : '▣' }}
                                </span>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-xl font-black text-white">
                                    {{ $tipo->nombre }}
                                </h3>

                                <p class="mt-2 text-4xl font-black text-violet-400">
                                    $ {{ number_format($tipo->precio, 0, ',', '.') }}
                                </p>

                                <p class="mt-2 text-sm text-slate-400">
                                    {{ $tipo->stock_disponible }} disponibles
                                </p>
                            </div>

                            <div class="mt-5 flex min-h-52 items-center justify-center rounded-2xl border border-white/10 bg-black/30 p-5">
                                @if(! $tipo->venta_online)
                                    <div class="text-center">
                                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl border border-yellow-400/40 text-2xl text-yellow-300">
                                            ▣
                                        </div>

                                        <p class="font-black text-yellow-100">
                                            Pago únicamente en efectivo
                                        </p>

                                        <p class="mt-2 text-sm text-slate-400">
                                            Acercate a la boletería oficial. Esta entrada no incluye QR de pago online.
                                        </p>
                                    </div>
                                @elseif(! $puedeVerQr)
                                    <div class="text-center">
                                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl border border-violet-400/40 text-2xl text-violet-300">
                                            🔒
                                        </div>

                                        <p class="font-black text-white">
                                            QR disponible al iniciar sesión
                                        </p>

                                        <p class="mt-2 text-sm text-slate-400">
                                            Para ver el QR de pago y comprar esta entrada, ingresá con una cuenta de usuario.
                                        </p>
                                    </div>
                                @elseif($tipo->qr_pago_data)
                                    <div class="rounded-xl bg-white p-3">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(170)->margin(1)->generate($tipo->qr_pago_data) !!}
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p class="font-black text-yellow-200">
                                            QR no generado
                                        </p>

                                        <p class="mt-2 text-sm text-slate-400">
                                            El administrador debe guardar el evento para generar el QR.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5">
                                @if(! $tipo->venta_online)
                                    <button
                                        type="button"
                                        class="w-full rounded-xl border border-yellow-400/50 px-4 py-3 text-sm font-black text-yellow-300"
                                    >
                                        Reservar {{ $tipo->nombre }}
                                    </button>
                                @elseif(! auth()->check())
                                    <a
                                        href="{{ route('login') }}"
                                        class="block w-full rounded-xl bg-violet-600 px-4 py-3 text-center text-sm font-black text-white transition hover:bg-violet-500"
                                    >
                                        Iniciar sesión para comprar
                                    </a>
                                @elseif(! auth()->user()->esUsuario())
                                    <button
                                        type="button"
                                        disabled
                                        class="w-full rounded-xl bg-slate-700 px-4 py-3 text-sm font-black text-slate-300"
                                    >
                                        Solo usuarios pueden comprar
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        class="w-full rounded-xl bg-violet-600 px-4 py-3 text-sm font-black text-white transition hover:bg-violet-500"
                                    >
                                        Comprar {{ $tipo->nombre }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif

</div>