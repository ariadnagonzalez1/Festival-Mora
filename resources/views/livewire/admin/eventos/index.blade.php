<section class="mt-6 space-y-4">
    @forelse($eventos as $evento)
        <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-4">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="h-28 w-full overflow-hidden rounded-2xl bg-slate-900 sm:w-44">
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

                    <div>
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
                            <span>{{ $evento->fecha_inicio?->translatedFormat('l, d \d\e F \d\e Y · H:i') }}</span>

                            @if($evento->lugar)
                                <span>{{ $evento->lugar }}</span>
                            @endif

                            @if($evento->ciudad)
                                <span>{{ $evento->ciudad }}</span>
                            @endif

                            <span>{{ $evento->tiposEntradas->count() }} tipos</span>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($evento->tiposEntradas as $tipo)
                                <span class="rounded-full border border-white/10 bg-black/20 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-white">
                                    {{ $tipo->nombre }}
                                    · $ {{ number_format($tipo->precio, 0, ',', '.') }}
                                    · {{ $tipo->stock_disponible }} stock
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

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