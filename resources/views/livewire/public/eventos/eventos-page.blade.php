<div class="min-h-screen bg-[#050512] pb-20 pt-28 text-white">

    {{-- HEADER --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <p class="text-sm font-black uppercase tracking-[0.45em] text-violet-400">
                Mora Producciones
            </p>

            <h1 class="mt-4 text-4xl font-black text-white md:text-6xl">
                Eventos
            </h1>

            <p class="mt-4 text-base leading-7 text-slate-400">
                Conocé los próximos eventos disponibles y elegí tu tipo de entrada.
            </p>
        </div>
    </section>

    {{-- FILTROS --}}
    <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-4 rounded-3xl border border-white/10 bg-white/[0.03] p-5 md:grid-cols-[1fr_260px]">
            <input
                type="text"
                wire:model.live.debounce.400ms="buscar"
                placeholder="Buscar por evento, ciudad o lugar..."
                class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
            >

            <select
                wire:model.live="ciudad"
                class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition focus:border-violet-400"
            >
                <option value="">Todas las ciudades</option>

                @foreach($ciudades as $nombreCiudad)
                    <option value="{{ $nombreCiudad }}">
                        {{ $nombreCiudad }}
                    </option>
                @endforeach
            </select>
        </div>
    </section>

    {{-- LISTADO --}}
    <section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
        @if($eventos->count())
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($eventos as $evento)
                    <x-public.event-card :evento="$evento" />
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-10 text-center">
                <p class="text-xl font-black text-white">
                    No hay eventos disponibles
                </p>

                <p class="mt-2 text-sm text-slate-400">
                    Probá cambiando los filtros o volvé más tarde.
                </p>
            </div>
        @endif
    </section>

    {{-- MODAL ENTRADAS --}}
    @if($mostrarModalEntradas && $eventoSeleccionado)
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
                                @elseif(! $this->puedeVerQr)
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