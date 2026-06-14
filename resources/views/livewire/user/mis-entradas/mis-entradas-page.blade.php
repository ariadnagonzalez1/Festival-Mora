<div class="min-h-screen bg-[#050512] text-white">

    {{-- HERO --}}
    <section class="relative overflow-hidden px-4 pt-32 pb-12 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_0%,rgba(124,58,237,0.28),transparent_28%),radial-gradient(circle_at_10%_40%,rgba(220,38,38,0.16),transparent_18%)]"></div>

        <div class="relative mx-auto max-w-7xl">
            <p class="text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Mi cuenta
            </p>

            <h1 class="mt-5 text-5xl font-black tracking-tight text-white sm:text-6xl">
                Hola, <span class="text-violet-500">{{ auth()->user()->nombre }}</span>
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-400">
                Acá vas a encontrar tus entradas digitales con QR y el historial de compras.
            </p>
        </div>
    </section>

    {{-- ENTRADAS --}}
    <section class="px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            @if($entradas->count())
                <div class="grid gap-6 xl:grid-cols-2">
                    @foreach($entradas as $entrada)
                        @php
                            $compra = $entrada->compra;
                            $estado = $compra?->estado ?? 'pendiente';

                            $estadoTexto = match($estado) {
                                'aprobada' => 'Aprobado',
                                'rechazada' => 'Rechazado',
                                'cancelada' => 'Cancelado',
                                'expirada' => 'Expirado',
                                default => 'Pendiente',
                            };

                            $estadoClase = match($estado) {
                                'aprobada' => 'border-emerald-400/30 bg-emerald-500/15 text-emerald-300',
                                'rechazada' => 'border-red-400/30 bg-red-500/15 text-red-300',
                                'cancelada' => 'border-slate-400/30 bg-slate-500/15 text-slate-300',
                                'expirada' => 'border-orange-400/30 bg-orange-500/15 text-orange-300',
                                default => 'border-yellow-400/30 bg-yellow-500/15 text-yellow-300',
                            };
                        @endphp

                        <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-5 transition hover:border-violet-400/30 hover:bg-white/[0.05]">
                            <div class="flex flex-col gap-5 sm:flex-row">

                                {{-- QR --}}
                                <div class="flex h-48 w-full flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white sm:w-48">
                                    @if($estado === 'aprobada' && $entrada->codigo_qr)
                                        <div class="p-3">
                                            {!! QrCode::format('svg')->size(170)->margin(1)->generate($entrada->codigo_qr) !!}
                                        </div>
                                    @else
                                        <div class="flex h-full w-full flex-col items-center justify-center bg-white/[0.08] px-5 text-center">
                                            <div class="text-4xl text-slate-600">
                                                ⌗
                                            </div>

                                            <p class="mt-3 text-sm text-slate-400">
                                                QR disponible al aprobarse el pago.
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- INFO --}}
                                <div class="flex min-w-0 flex-1 flex-col justify-between">
                                    <div>
                                        <span class="inline-flex rounded-full border px-3 py-1 text-[11px] font-black uppercase tracking-widest {{ $estadoClase }}">
                                            {{ $estadoTexto }}
                                        </span>

                                        <h2 class="mt-4 text-2xl font-black text-white">
                                            {{ $entrada->evento?->titulo ?? 'Evento' }}
                                        </h2>

                                        <div class="mt-4 space-y-2 text-sm text-slate-400">
                                            <p>
                                                {{ $entrada->evento?->fecha_inicio?->translatedFormat('l, d \d\e F \d\e Y · H:i') }}
                                            </p>

                                            <p>
                                                {{ $entrada->evento?->lugar ?? 'Lugar no definido' }}
                                            </p>
                                        </div>

                                        <div class="mt-4">
                                            <p class="font-bold text-white">
                                                {{ $entrada->tipoEntrada?->nombre ?? $entrada->sector_nombre ?? 'Entrada' }}
                                            </p>

                                            <p class="mt-1 text-slate-400">
                                                {{ $entrada->nombre_comprador }} {{ $entrada->apellido_comprador }}
                                                · DNI {{ $entrada->dni_comprador }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-5 flex items-center justify-between gap-4">
                                        <p class="text-2xl font-black text-white">
                                            $ {{ number_format($entrada->precio_pagado, 0, ',', '.') }}
                                        </p>

                                        @if($entrada->compra_id)
                                            <button
                                                type="button"
                                                wire:click="descargarComprobante({{ $entrada->compra_id }})"
                                                class="rounded-xl border border-white/10 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10"
                                            >
                                                Descargar
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-[2rem] border border-white/10 bg-white/[0.03] px-6 py-20 text-center">
                    <h2 class="text-3xl font-black text-white">
                        Todavía no tenés entradas
                    </h2>

                    <p class="mx-auto mt-4 max-w-xl text-slate-400">
                        Cuando compres entradas, van a aparecer acá con su código QR.
                    </p>

                    <a href="{{ route('public.eventos') }}"
                       class="mt-8 inline-flex rounded-xl bg-violet-600 px-6 py-3 text-sm font-black text-white transition hover:bg-violet-500">
                        Ver eventos
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- HISTORIAL --}}
    <section class="px-4 pb-24 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <h2 class="text-3xl font-black text-white">
                Historial de compras
            </h2>

            <div class="mt-6 hidden overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03] lg:block">
                <table class="w-full text-left">
                    <thead class="bg-white/[0.03]">
                        <tr class="text-xs font-bold uppercase tracking-[0.25em] text-slate-400">
                            <th class="px-4 py-4">Fecha</th>
                            <th class="px-4 py-4">Evento</th>
                            <th class="px-4 py-4">Tipo</th>
                            <th class="px-4 py-4">Total</th>
                            <th class="px-4 py-4">Estado</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">
                        @forelse($compras as $compra)
                            @php
                                $primerItem = $compra->items->first();
                                $eventoNombre = $primerItem?->nombre_evento ?? $primerItem?->evento?->titulo ?? 'Sin evento';

                                $tipos = $compra->items->map(function ($item) {
                                    return ($item->nombre_tipo_entrada ?? $item->tipoEntrada?->nombre ?? 'Entrada') . ' × ' . $item->cantidad;
                                })->join(', ');

                                $estadoTexto = match($compra->estado) {
                                    'aprobada' => 'Aprobado',
                                    'rechazada' => 'Rechazado',
                                    'cancelada' => 'Cancelado',
                                    'expirada' => 'Expirado',
                                    default => 'Pendiente',
                                };

                                $estadoClase = match($compra->estado) {
                                    'aprobada' => 'border-emerald-400/30 bg-emerald-500/15 text-emerald-300',
                                    'rechazada' => 'border-red-400/30 bg-red-500/15 text-red-300',
                                    'cancelada' => 'border-slate-400/30 bg-slate-500/15 text-slate-300',
                                    'expirada' => 'border-orange-400/30 bg-orange-500/15 text-orange-300',
                                    default => 'border-yellow-400/30 bg-yellow-500/15 text-yellow-300',
                                };
                            @endphp

                            <tr class="text-sm text-slate-300">
                                <td class="px-4 py-4 font-bold text-white">
                                    {{ $compra->created_at?->format('Y-m-d') }}
                                </td>

                                <td class="px-4 py-4 font-bold text-white">
                                    {{ $eventoNombre }}
                                </td>

                                <td class="px-4 py-4 font-bold text-white">
                                    {{ $tipos ?: '-' }}
                                </td>

                                <td class="px-4 py-4 font-black text-white">
                                    $ {{ number_format($compra->total, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full border px-3 py-1 text-[11px] font-black uppercase tracking-widest {{ $estadoClase }}">
                                        {{ $estadoTexto }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                                    No hay compras registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- MOBILE HISTORIAL --}}
            <div class="mt-6 space-y-4 lg:hidden">
                @foreach($compras as $compra)
                    @php
                        $primerItem = $compra->items->first();
                        $eventoNombre = $primerItem?->nombre_evento ?? $primerItem?->evento?->titulo ?? 'Sin evento';
                    @endphp

                    <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-sm text-slate-400">
                            {{ $compra->created_at?->format('Y-m-d') }}
                        </p>

                        <h3 class="mt-2 font-black text-white">
                            {{ $eventoNombre }}
                        </h3>

                        <p class="mt-3 text-2xl font-black text-white">
                            $ {{ number_format($compra->total, 0, ',', '.') }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

</div>