<div class="min-h-screen bg-[#050512] pb-10 text-white">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-4xl font-black text-white">
                Eventos
            </h1>

            <p class="mt-2 text-slate-400">
                Crear, editar, duplicar y eliminar eventos del catálogo.
            </p>
        </div>

        <x-admin.ui.button wire:click="abrirCrear">
            <span class="text-lg">+</span>
            Nuevo evento
        </x-admin.ui.button>
    </div>

    @if(session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mt-6 rounded-2xl border border-red-400/20 bg-red-500/10 px-5 py-4 text-sm text-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-8 rounded-3xl border border-white/10 bg-white/[0.03] p-5">
        <input
            type="text"
            wire:model.live.debounce.400ms="buscar"
            placeholder="Buscar evento por nombre, ciudad o lugar..."
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
        >
    </div>

    @include('livewire.admin.eventos.index')

    @if($modalCreate)
        @include('livewire.admin.eventos.create')
    @endif

    @if($modalEdit)
        @include('livewire.admin.eventos.edit')
    @endif

</div>