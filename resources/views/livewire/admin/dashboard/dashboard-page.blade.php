<div class="min-h-screen bg-[#050512] pb-10 text-white">

    {{-- MOBILE HEADER --}}
    <div class="mb-6 flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.03] p-4 lg:hidden">
        <div class="flex items-center gap-3">
            <img 
                src="{{ asset('images/logo-mora.png') }}" 
                class="h-10 w-10 rounded-xl object-cover" 
                alt="Mora"
            >

            <div>
                <p class="font-black tracking-[0.2em]">
                    MORA
                </p>
                <p class="text-[10px] tracking-[0.35em] text-slate-400">
                    ADMIN
                </p>
            </div>
        </div>

        <a href="{{ route('public.inicio') }}" class="text-sm font-bold text-violet-300">
            Sitio
        </a>
    </div>

    {{-- TÍTULO --}}
    <div>
        <h1 class="text-4xl font-black text-white">
            Dashboard
        </h1>

        <p class="mt-2 text-slate-400">
            Resumen de ventas y operaciones.
        </p>
    </div>

    {{-- TARJETAS --}}
    <section class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-3xl border border-emerald-400/10 bg-emerald-500/15 p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-200">
                    Ingresos
                </p>
                <span class="text-2xl text-emerald-300">$</span>
            </div>

            <p class="mt-5 text-3xl font-black text-white">
                $ {{ number_format($ingresos, 0, ',', '.') }}
            </p>
        </div>

        <div class="rounded-3xl border border-violet-400/10 bg-violet-500/15 p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-violet-200">
                    Entradas vendidas
                </p>
                <span class="text-2xl text-violet-300">🎟</span>
            </div>

            <p class="mt-5 text-3xl font-black text-white">
                {{ $entradasVendidas }}
            </p>
        </div>

        <div class="rounded-3xl border border-blue-400/10 bg-blue-500/15 p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-200">
                    Eventos activos
                </p>
                <span class="text-2xl text-blue-300">↗</span>
            </div>

            <p class="mt-5 text-3xl font-black text-white">
                {{ $eventosActivos }}
            </p>
        </div>

        <div class="rounded-3xl border border-fuchsia-400/10 bg-fuchsia-500/15 p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-fuchsia-200">
                    Compradores
                </p>
                <span class="text-2xl text-fuchsia-300">👥</span>
            </div>

            <p class="mt-5 text-3xl font-black text-white">
                {{ $compradores }}
            </p>
        </div>

    </section>

    {{-- CONTENIDO PRINCIPAL --}}
    <section class="mt-8 grid gap-6 xl:grid-cols-2">

        {{-- VENTAS POR EVENTO --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
            <h2 class="text-xl font-black text-white">
                Ventas por evento
            </h2>

            <div class="mt-6 space-y-5">
                @forelse($ventasPorEvento as $evento)
                    @php
                        $porcentaje = ($evento->entradas_count / $maxEntradasEvento) * 100;
                    @endphp

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-4">
                            <p class="font-bold text-white">
                                {{ $evento->titulo }}
                            </p>

                            <p class="text-sm text-slate-300">
                                {{ $evento->entradas_count }} entradas
                            </p>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-white/5">
                            <div 
                                class="h-full rounded-full bg-violet-500"
                                style="width: {{ $porcentaje }}%"
                            ></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">
                        Todavía no hay eventos con ventas.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- ÚLTIMAS COMPRAS --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
            <h2 class="text-xl font-black text-white">
                Últimas compras
            </h2>

            <div class="mt-6 divide-y divide-white/10">
                @forelse($ultimasCompras as $compra)
                    <div class="flex items-center justify-between gap-4 py-4">
                        <div>
                            <p class="font-bold text-white">
                                {{ $compra->comprador_nombre ?? $compra->usuario?->nombre }}
                                {{ $compra->comprador_apellido ?? $compra->usuario?->apellido }}
                            </p>

                            <p class="mt-1 text-sm text-slate-400">
                                {{ $compra->created_at?->format('Y-m-d') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-black text-white">
                                $ {{ number_format($compra->total, 0, ',', '.') }}
                            </p>

                            <p class="mt-1 text-sm
                                @if($compra->estado === 'aprobada') text-emerald-300
                                @elseif($compra->estado === 'rechazada') text-red-300
                                @else text-yellow-300
                                @endif">
                                {{ ucfirst($compra->estado) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-sm text-slate-400">
                        Todavía no hay compras registradas.
                    </p>
                @endforelse
            </div>
        </div>

    </section>

</div>