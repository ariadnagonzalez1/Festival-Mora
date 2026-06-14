<div class="space-y-5">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Nombre artístico
        </label>

        <input 
            type="text"
            wire:model.defer="nombre"
            placeholder="Ej: Luna Vega"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >

        @error('nombre')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Género
        </label>

        <input 
            type="text"
            wire:model.defer="genero"
            placeholder="Ej: Electrónica, Indie, Rock, House..."
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >

        @error('genero')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Instagram
        </label>

        <input 
            type="text"
            wire:model.defer="instagram_url"
            placeholder="Ej: @usuario o https://instagram.com/usuario"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >

        @error('instagram_url')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Foto del artista
        </label>

        <input 
            type="file"
            wire:model="foto_file"
            accept="image/*"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-slate-300 outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-violet-600 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-violet-500"
        >

        @error('foto_file')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror

        <div wire:loading wire:target="foto_file" class="mt-2 text-sm text-violet-300">
            Subiendo foto...
        </div>

        @if($foto_file)
            <div class="mt-3 overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                <img 
                    src="{{ $foto_file->temporaryUrl() }}" 
                    alt="Vista previa"
                    class="h-48 w-full object-cover"
                >
            </div>
        @elseif($foto_url)
            <div class="mt-3 overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                <img 
                    src="{{ asset($foto_url) }}" 
                    alt="Foto actual"
                    class="h-48 w-full object-cover"
                >
            </div>
        @endif
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Bio
        </label>

        <textarea
            wire:model.defer="bio"
            rows="4"
            placeholder="Breve descripción del artista..."
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        ></textarea>

        @error('bio')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <label class="flex items-center gap-3 text-sm text-slate-300">
        <input 
            type="checkbox"
            wire:model.defer="destacado"
            class="rounded border-white/10 bg-white/[0.06]"
        >

        Mostrar como artista destacado en el inicio
    </label>
</div>