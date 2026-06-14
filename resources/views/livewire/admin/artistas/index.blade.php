<section class="mt-6">
    @if($artistas->count())
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($artistas as $artista)
                <article class="flex min-h-[230px] flex-col justify-between rounded-3xl border border-white/10 bg-white/[0.03] p-5 transition hover:border-violet-400/30 hover:bg-white/[0.05]">

                    {{-- INFO PRINCIPAL --}}
                    <div>
                        <div class="flex items-start gap-4">
                            {{-- FOTO --}}
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl border border-white/10 bg-slate-900">
                                @if($artista->foto_url)
                                    <img 
                                        src="{{ asset($artista->foto_url) }}" 
                                        alt="{{ $artista->nombre }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-[radial-gradient(circle_at_top,_#6d28d9,_#020617_70%)] text-2xl text-white">
                                        ♪
                                    </div>
                                @endif
                            </div>

                            {{-- TEXTO --}}
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold uppercase tracking-[0.35em] text-violet-300">
                                    {{ $artista->genero ?? 'Sin género' }}
                                </p>

                                <h2 class="mt-2 truncate text-xl font-black text-white">
                                    {{ $artista->nombre }}
                                </h2>

                                @if($artista->instagram_url)
                                <a 
                                    href="{{ str_starts_with($artista->instagram_url, 'http') ? $artista->instagram_url : 'https://instagram.com/' . ltrim($artista->instagram_url, '@') }}"
                                    target="_blank"
                                    class="mt-1 block break-all text-sm leading-5 text-slate-400 transition hover:text-violet-300"
                                >
                                    {{ $artista->instagram_url }}
                                </a>
                            @endif
                            </div>
                        </div>

                        {{-- DESTACADO --}}
                        @if($artista->destacado)
                            <div class="mt-4">
                                <span class="inline-flex rounded-full bg-violet-500/15 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-violet-200">
                                    Destacado
                                </span>
                            </div>
                        @endif

                        {{-- BIO --}}
                        @if($artista->bio)
                            <p class="mt-4 line-clamp-2 text-sm leading-6 text-slate-400">
                                {{ $artista->bio }}
                            </p>
                        @else
                            <p class="mt-4 text-sm leading-6 text-slate-500">
                                Sin biografía cargada.
                            </p>
                        @endif
                    </div>

                    {{-- BOTONES --}}
                    <div class="mt-5 flex items-center gap-2">
                        <x-admin.ui.button 
                            size="sm" 
                            variant="secondary" 
                            wire:click="abrirEditar({{ $artista->id }})"
                        >
                            ✎ Editar
                        </x-admin.ui.button>

                        <x-admin.ui.button
                            size="sm"
                            variant="danger"
                            wire:click="eliminar({{ $artista->id }})"
                            wire:confirm="¿Seguro que querés eliminar este artista?"
                        >
                            🗑
                        </x-admin.ui.button>
                    </div>

                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $artistas->links() }}
        </div>
    @else
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] px-6 py-16 text-center">
            <h2 class="text-2xl font-black text-white">
                No hay artistas cargados
            </h2>

            <p class="mt-3 text-slate-400">
                Cargá artistas para mostrarlos en la pantalla de inicio y asociarlos a eventos.
            </p>

            <div class="mt-6">
                <x-admin.ui.button wire:click="abrirCrear">
                    Crear artista
                </x-admin.ui.button>
            </div>
        </div>
    @endif
</section>