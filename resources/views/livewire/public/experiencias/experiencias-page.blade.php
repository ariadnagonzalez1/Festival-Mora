<div class="min-h-screen bg-[#050512] text-white">

    {{-- HERO --}}
    <section class="relative overflow-hidden px-4 pt-32 pb-20 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_0%,rgba(124,58,237,0.28),transparent_28%),radial-gradient(circle_at_10%_40%,rgba(220,38,38,0.18),transparent_18%)]"></div>

        <div class="relative mx-auto max-w-7xl text-center">
            <div class="mb-8 inline-flex items-center rounded-full border border-violet-400/40 bg-violet-500/10 px-5 py-2">
                <span class="text-xs font-bold uppercase tracking-[0.45em] text-violet-300">
                    Archivo Mora
                </span>
            </div>

            <h1 class="text-5xl font-black tracking-tight text-white sm:text-6xl">
                Experiencias <span class="text-violet-500">Mora</span>
            </h1>

            <p class="mx-auto mt-6 max-w-3xl text-lg leading-8 text-slate-400">
                Reviví los festivales, shows y experiencias que marcaron la historia de Mora Producciones.
            </p>
        </div>
    </section>

    {{-- ESTADÍSTICAS --}}
    <section class="px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-8 text-center">
                <p class="text-4xl font-black text-violet-400">
                    {{ $eventosRealizados }}
                </p>
                <p class="mt-3 text-xs font-bold uppercase tracking-[0.3em] text-slate-400">
                    Eventos realizados
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-8 text-center">
                <p class="text-4xl font-black text-violet-400">
                    {{ number_format($asistentesTotales, 0, ',', '.') }}+
                </p>
                <p class="mt-3 text-xs font-bold uppercase tracking-[0.3em] text-slate-400">
                    Entradas generadas
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-8 text-center">
                <p class="text-4xl font-black text-violet-400">
                    {{ $ciudadesRecorridas }}
                </p>
                <p class="mt-3 text-xs font-bold uppercase tracking-[0.3em] text-slate-400">
                    Ciudades recorridas
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-8 text-center">
                <p class="text-4xl font-black text-violet-400">
                    {{ $artistasPresentados }}+
                </p>
                <p class="mt-3 text-xs font-bold uppercase tracking-[0.3em] text-slate-400">
                    Artistas presentados
                </p>
            </div>
        </div>
    </section>

    {{-- FILTROS --}}
    <section class="px-4 pb-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="grid gap-4 md:grid-cols-[1fr_220px_auto]">
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                            Buscar experiencia
                        </label>

                        <input
                            type="text"
                            wire:model.live.debounce.400ms="buscar"
                            placeholder="Buscar por evento, lugar o ciudad..."
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                            Año
                        </label>

                        <select
                            wire:model.live="anio"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition focus:border-violet-400"
                        >
                            <option value="">Todos</option>

                            @foreach($anios as $anioItem)
                                <option value="{{ $anioItem }}">
                                    {{ $anioItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button
                            type="button"
                            wire:click="limpiarFiltros"
                            class="w-full rounded-xl border border-white/10 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10 md:w-auto"
                        >
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LISTADO / TIMELINE --}}
    <section class="px-4 pb-24 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10">
                <p class="text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                    Memorias
                </p>

                <h2 class="mt-4 text-4xl font-black text-white">
                    Eventos que hicieron historia
                </h2>
            </div>

            @if($experiencias->count())
                <div class="relative">
                    <div class="absolute left-1/2 top-0 hidden h-full w-px -translate-x-1/2 bg-white/10 lg:block"></div>

                    <div class="space-y-14">
                        @foreach($experiencias as $index => $evento)
                            <div class="relative grid gap-8 lg:grid-cols-2 lg:items-start">
                                <div class="absolute left-1/2 top-8 hidden -translate-x-1/2 rounded-full border border-white/10 bg-[#050512] px-4 py-1 text-xs font-bold text-slate-400 lg:block">
                                    {{ $evento->fecha_inicio?->format('Y') }}
                                </div>

                                @if($index % 2 === 0)
                                    <div>
                                        <x-public.experience-card :evento="$evento" />
                                    </div>
                                    <div class="hidden lg:block"></div>
                                @else
                                    <div class="hidden lg:block"></div>
                                    <div>
                                        <x-public.experience-card :evento="$evento" />
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-12">
                    {{ $experiencias->links() }}
                </div>
            @else
                <div class="rounded-[2rem] border border-white/10 bg-white/[0.03] px-6 py-20 text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.45em] text-violet-300">
                        Sin experiencias
                    </p>

                    <h2 class="mt-4 text-3xl font-black text-white">
                        Todavía no hay eventos finalizados
                    </h2>

                    <p class="mx-auto mt-4 max-w-xl text-slate-400">
                        Cuando los eventos se realicen, van a aparecer automáticamente en esta sección.
                    </p>
                </div>
            @endif
        </div>
    </section>

</div>