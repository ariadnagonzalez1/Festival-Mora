<div class="space-y-5">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Nombre completo
        </label>

        <input
            type="text"
            wire:model.defer="nombre_completo"
            placeholder="Ej: María Pérez"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >

        @error('nombre_completo')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-300">
                Email
            </label>

            <input
                type="email"
                wire:model.defer="email"
                placeholder="usuario@email.com"
                class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
            >

            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-slate-300">
                DNI
            </label>

            <input
                type="text"
                wire:model.defer="dni"
                placeholder="Ej: 32456789"
                class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
            >

            @error('dni')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-300">
                Rol
            </label>

            <select
                wire:model.defer="rol"
                class="w-full rounded-xl border border-white/10 bg-[#111122] px-4 py-3 text-white outline-none focus:border-violet-400"
            >
                <option value="usuario">Usuario</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-slate-300">
                Estado
            </label>

            <select
                wire:model.defer="estado"
                class="w-full rounded-xl border border-white/10 bg-[#111122] px-4 py-3 text-white outline-none focus:border-violet-400"
            >
                <option value="activo">Activo</option>
                <option value="bloqueado">Bloqueado</option>
            </select>
        </div>
    </div>
</div>