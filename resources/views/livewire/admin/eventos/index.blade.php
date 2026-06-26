<section class="mt-6 space-y-4">
    @forelse($eventos as $evento)
        <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-4">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                {{-- INFO EVENTO --}}
                <div class="flex flex-1 flex-col gap-4 sm:flex-row">
                    <div class="h-28 w-full overflow-hidden rounded-2xl bg-slate-900 sm:w-44 sm:flex-shrink-0">
                        @if($evento->imagen_url)
                            <img 
                                src="{{ asset($evento->imagen_url) }}" 
                                class="h-full w-full object-cover" 
                                alt="{{ $evento->titulo }}"
                            >
                        @else
                            <div class="h-full w-full bg-[radial-gradient(circle_at_top,_#6d28d9,_#020617_70%)]"></div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-xl font-black text-white">
                                {{ $evento->titulo }}
                            </h2>

                            @php
                                $estadoVisual = $evento->fecha_inicio && $evento->fecha_inicio->lte(now())
                                    ? 'finalizado'
                                    : 'publicado';
                            @endphp

                            <span class="rounded-full border border-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest
                                {{ $estadoVisual === 'publicado' ? 'text-emerald-300' : 'text-slate-300' }}">
                                {{ $estadoVisual }}
                            </span>

                            @if($evento->mostrar_en_banner)
                                <span class="rounded-full bg-violet-500/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-violet-200">
                                    Banner
                                </span>
                            @endif
                        </div>

                        <div class="mt-3 flex flex-wrap gap-4 text-sm text-slate-400">
                            <span>
                                {{ $evento->fecha_inicio?->translatedFormat('l, d \d\e F \d\e Y · H:i') }}
                            </span>

                            @if($evento->lugar)
                                <span>{{ $evento->lugar }}</span>
                            @endif

                            @if($evento->ciudad)
                                <span>{{ $evento->ciudad }}</span>
                            @endif

                            <span>{{ $evento->tiposEntradas->count() }} tipos</span>
                        </div>

                        {{-- TIPOS COMO CHIPS --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($evento->tiposEntradas as $tipo)
                                <span class="rounded-full border border-white/10 bg-black/20 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-white">
                                    {{ $tipo->nombre }}
                                    · $ {{ number_format($tipo->precio, 0, ',', '.') }}
                                    · {{ $tipo->stock_disponible }} stock
                                </span>
                            @endforeach
                        </div>

                        {{-- QR COMPACTOS --}}
                        <div class="mt-5 rounded-2xl border border-violet-400/20 bg-violet-500/10 p-4">
                            <div class="mb-4 flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.25em] text-violet-300">
                                        QRs de pago
                                    </p>
                                    <p class="mt-1 text-xs text-slate-400">
                                        Generados por tipo de entrada.
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                                @foreach($evento->tiposEntradas as $tipo)
                                    <div class="rounded-2xl border border-white/10 bg-black/25 p-3 text-center">
                                        <p class="mb-3 truncate text-xs font-black uppercase tracking-widest text-white">
                                            {{ $tipo->nombre }}
                                        </p>

                                        @if($tipo->qr_pago_data)
                                            <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-xl bg-white p-2">
                                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(95)->margin(1)->generate($tipo->qr_pago_data) !!}
                                            </div>

                                    @if($tipo->qr_pago_generado_at)
                                        <p class="mt-3 text-[11px] text-slate-400">
                                            Creado: {{ \Carbon\Carbon::parse($tipo->qr_pago_generado_at)->format('d/m/Y H:i') }}
                                        </p>
                                    @else
                                        <p class="mt-3 text-[11px] text-slate-500">
                                            Sin fecha
                                        </p>
                                    @endif

                                    @if($tipo->qr_pago_codigo)
                                        <p class="mt-2 break-all rounded-lg border border-white/10 bg-black/30 px-2 py-1 text-[10px] font-bold text-violet-200">
                                            {{ $tipo->qr_pago_codigo }}
                                        </p>
                                    @endif
                                        @else
                                            <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-xl border border-dashed border-white/20 bg-white/[0.03]">
                                                <span class="text-2xl text-slate-500">▦</span>
                                            </div>

                                            <p class="mt-3 text-[11px] text-yellow-300">
                                                Sin QR
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTONES --}}
                <div class="flex gap-2 lg:flex-col">
                    <x-admin.ui.button size="icon" variant="secondary" wire:click="abrirEditar({{ $evento->id }})">
                        ✎
                    </x-admin.ui.button>

                    <x-admin.ui.button size="icon" variant="secondary" wire:click="duplicar({{ $evento->id }})">
                        ⧉
                    </x-admin.ui.button>

                    <x-admin.ui.button
                        size="icon"
                        variant="danger"
                        wire:click="eliminar({{ $evento->id }})"
                        wire:confirm="¿Seguro que querés eliminar este evento?"
                    >
                        🗑
                    </x-admin.ui.button>
                </div>

            </div>
        </article>
    @empty
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] px-6 py-16 text-center">
            <h2 class="text-2xl font-black text-white">
                No hay eventos cargados
            </h2>

            <p class="mt-3 text-slate-400">
                Creá el primer evento para mostrarlo en la web.
            </p>

            <div class="mt-6">
                <x-admin.ui.button wire:click="abrirCrear">
                    Crear evento
                </x-admin.ui.button>
            </div>
        </div>
    @endforelse

    <div class="pt-4">
        {{ $eventos->links() }}
    </div>
</section>