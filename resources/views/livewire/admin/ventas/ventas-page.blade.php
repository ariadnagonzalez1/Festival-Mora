<div class="min-h-screen bg-[#050512] pb-10 text-white">

    <div>
        <h1 class="text-4xl font-black text-white">
            Ventas
        </h1>

        <p class="mt-2 text-slate-400">
            Compradores, pagos y entradas generadas.
        </p>
    </div>

    {{-- FILTROS --}}
    <div class="mt-8 flex flex-wrap gap-3">
        <button 
            type="button"
            wire:click="limpiarFiltro"
            class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] transition
            {{ $estadoFiltro === '' ? 'border-violet-400 bg-violet-500/20 text-white' : 'border-white/10 text-slate-300 hover:bg-white/5' }}"
        >
            Todos
        </button>

        <button 
            type="button"
            wire:click="filtrarPorEstado('pendiente')"
            class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] transition
            {{ $estadoFiltro === 'pendiente' ? 'border-yellow-400 bg-yellow-500/20 text-yellow-200' : 'border-white/10 text-slate-300 hover:bg-white/5' }}"
        >
            Pendiente
        </button>

        <button 
            type="button"
            wire:click="filtrarPorEstado('aprobada')"
            class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] transition
            {{ $estadoFiltro === 'aprobada' ? 'border-emerald-400 bg-emerald-500/20 text-emerald-200' : 'border-white/10 text-slate-300 hover:bg-white/5' }}"
        >
            Aprobado
        </button>

        <button 
            type="button"
            wire:click="filtrarPorEstado('rechazada')"
            class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] transition
            {{ $estadoFiltro === 'rechazada' ? 'border-red-400 bg-red-500/20 text-red-200' : 'border-white/10 text-slate-300 hover:bg-white/5' }}"
        >
            Rechazado
        </button>

        <button 
            type="button"
            wire:click="filtrarPorEstado('cancelada')"
            class="rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] transition
            {{ $estadoFiltro === 'cancelada' ? 'border-slate-400 bg-slate-500/20 text-slate-200' : 'border-white/10 text-slate-300 hover:bg-white/5' }}"
        >
            Cancelado
        </button>
    </div>

    {{-- TABLA DESKTOP --}}
    <div class="mt-6 hidden overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03] lg:block">
        <table class="w-full text-left">
            <thead class="bg-white/[0.03]">
                <tr class="text-xs font-bold uppercase tracking-[0.25em] text-slate-400">
                    <th class="px-4 py-4">Fecha</th>
                    <th class="px-4 py-4">Comprador</th>
                    <th class="px-4 py-4">DNI</th>
                    <th class="px-4 py-4">Evento</th>
                    <th class="px-4 py-4">Tipo</th>
                    <th class="px-4 py-4">Total</th>
                    <th class="px-4 py-4">Estado</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/10">
                @forelse($ventas as $venta)
                    @php
                        $primerItem = $venta->items->first();
                        $eventoNombre = $primerItem?->nombre_evento ?? $primerItem?->evento?->titulo ?? 'Sin evento';

                        $tipos = $venta->items->map(function ($item) {
                            return ($item->nombre_tipo_entrada ?? $item->tipoEntrada?->nombre ?? 'Entrada') . ' × ' . $item->cantidad;
                        })->join(', ');

                        $estadoTexto = match($venta->estado) {
                            'aprobada' => 'Aprobado',
                            'rechazada' => 'Rechazado',
                            'cancelada' => 'Cancelado',
                            'expirada' => 'Expirado',
                            default => 'Pendiente',
                        };

                        $estadoClase = match($venta->estado) {
                            'aprobada' => 'border-emerald-400/30 bg-emerald-500/15 text-emerald-300',
                            'rechazada' => 'border-red-400/30 bg-red-500/15 text-red-300',
                            'cancelada' => 'border-slate-400/30 bg-slate-500/15 text-slate-300',
                            'expirada' => 'border-orange-400/30 bg-orange-500/15 text-orange-300',
                            default => 'border-yellow-400/30 bg-yellow-500/15 text-yellow-300',
                        };
                    @endphp

                    <tr class="text-sm text-slate-300 transition hover:bg-white/[0.03]">
                        <td class="px-4 py-4 font-bold text-white">
                            {{ $venta->created_at?->format('Y-m-d') }}
                        </td>

                        <td class="px-4 py-4 font-bold text-white">
                            {{ $venta->comprador_nombre ?? $venta->usuario?->nombre }}
                            {{ $venta->comprador_apellido ?? $venta->usuario?->apellido }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $venta->comprador_dni ?? $venta->usuario?->dni ?? '-' }}
                        </td>

                        <td class="px-4 py-4 font-bold text-white">
                            {{ $eventoNombre }}
                        </td>

                        <td class="px-4 py-4 font-bold text-white">
                            {{ $tipos ?: '-' }}
                        </td>

                        <td class="px-4 py-4 font-black text-white">
                            $ {{ number_format($venta->total, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-4">
                            <span class="inline-flex rounded-full border px-3 py-1 text-[11px] font-black uppercase tracking-widest {{ $estadoClase }}">
                                {{ $estadoTexto }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center text-slate-400">
                            Todavía no hay ventas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- CARDS MOBILE --}}
    <div class="mt-6 space-y-4 lg:hidden">
        @forelse($ventas as $venta)
            @php
                $primerItem = $venta->items->first();
                $eventoNombre = $primerItem?->nombre_evento ?? $primerItem?->evento?->titulo ?? 'Sin evento';

                $tipos = $venta->items->map(function ($item) {
                    return ($item->nombre_tipo_entrada ?? $item->tipoEntrada?->nombre ?? 'Entrada') . ' × ' . $item->cantidad;
                })->join(', ');

                $estadoTexto = match($venta->estado) {
                    'aprobada' => 'Aprobado',
                    'rechazada' => 'Rechazado',
                    'cancelada' => 'Cancelado',
                    'expirada' => 'Expirado',
                    default => 'Pendiente',
                };

                $estadoClase = match($venta->estado) {
                    'aprobada' => 'border-emerald-400/30 bg-emerald-500/15 text-emerald-300',
                    'rechazada' => 'border-red-400/30 bg-red-500/15 text-red-300',
                    'cancelada' => 'border-slate-400/30 bg-slate-500/15 text-slate-300',
                    'expirada' => 'border-orange-400/30 bg-orange-500/15 text-orange-300',
                    default => 'border-yellow-400/30 bg-yellow-500/15 text-yellow-300',
                };
            @endphp

            <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-black text-white">
                            {{ $venta->comprador_nombre ?? $venta->usuario?->nombre }}
                            {{ $venta->comprador_apellido ?? $venta->usuario?->apellido }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-400">
                            DNI: {{ $venta->comprador_dni ?? $venta->usuario?->dni ?? '-' }}
                        </p>
                    </div>

                    <span class="inline-flex rounded-full border px-3 py-1 text-[11px] font-black uppercase tracking-widest {{ $estadoClase }}">
                        {{ $estadoTexto }}
                    </span>
                </div>

                <div class="mt-5 space-y-2 text-sm text-slate-300">
                    <p><span class="text-slate-500">Fecha:</span> {{ $venta->created_at?->format('Y-m-d') }}</p>
                    <p><span class="text-slate-500">Evento:</span> {{ $eventoNombre }}</p>
                    <p><span class="text-slate-500">Tipo:</span> {{ $tipos ?: '-' }}</p>
                </div>

                <p class="mt-5 text-2xl font-black text-white">
                    $ {{ number_format($venta->total, 0, ',', '.') }}
                </p>
            </article>
        @empty
            <div class="rounded-3xl border border-white/10 bg-white/[0.03] px-6 py-16 text-center">
                <h2 class="text-2xl font-black text-white">
                    No hay ventas registradas
                </h2>

                <p class="mt-3 text-slate-400">
                    Cuando los usuarios compren entradas, van a aparecer acá.
                </p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $ventas->links() }}
    </div>

</div>