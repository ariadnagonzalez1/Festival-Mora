<div class="min-h-screen bg-[#050512] text-white">

    {{-- HERO --}}
    <section class="relative overflow-hidden px-4 pt-32 pb-16 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_0%,rgba(124,58,237,0.28),transparent_28%),radial-gradient(circle_at_20%_30%,rgba(59,130,246,0.12),transparent_30%)]"></div>

        <div class="relative mx-auto max-w-7xl">
            <p class="text-xs font-bold uppercase tracking-[0.45em] text-slate-400">
                Cartelera
            </p>

            <h1 class="mt-5 text-5xl font-black tracking-tight text-white sm:text-6xl">
                Todos los eventos
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-400">
                Explorá la agenda completa de Mora Producciones y conseguí tu entrada para los próximos festivales y shows.
            </p>
        </div>
    </section>

    {{-- FILTROS --}}
    <section class="px-4 pb-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                <div class="grid gap-4 md:grid-cols-[1fr_240px_auto]">

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                            Buscar evento
                        </label>

                        <input
                            type="text"
                            wire:model.live.debounce.400ms="buscar"
                            placeholder="Buscar por nombre, ciudad o lugar..."
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                            Ciudad
                        </label>

                        <select
                            wire:model.live="ciudad"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition focus:border-violet-400"
                        >
                            <option value="">Todas</option>

                            @foreach($ciudades as $ciudadItem)
                                <option value="{{ $ciudadItem }}">
                                    {{ $ciudadItem }}
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

    {{-- EVENTOS --}}
    <section class="px-4 pb-24 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            @if($eventos->count())
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($eventos as $evento)
                        <x-public.event-card :evento="$evento" />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $eventos->links() }}
                </div>
            @else
                <div class="rounded-[2rem] border border-white/10 bg-white/[0.03] px-6 py-20 text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.45em] text-violet-300">
                        Sin resultados
                    </p>

                    <h2 class="mt-4 text-3xl font-black text-white">
                        No hay eventos disponibles
                    </h2>

                    <p class="mx-auto mt-4 max-w-xl text-slate-400">
                        Todavía no hay eventos publicados con entradas online disponibles o no encontramos resultados para tu búsqueda.
                    </p>

                    <button
                        wire:click="limpiarFiltros"
                        class="mt-8 rounded-xl bg-violet-600 px-6 py-3 text-sm font-black text-white transition hover:bg-violet-500"
                    >
                        Ver todos
                    </button>
                </div>
            @endif

        </div>
    </section>

</div>