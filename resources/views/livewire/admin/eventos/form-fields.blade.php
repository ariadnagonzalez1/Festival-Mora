<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-bold text-slate-300">Título</label>

        <input 
            type="text" 
            wire:model.defer="titulo" 
            placeholder="Ej: Festival Nocturno 2026"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >

        @error('titulo') 
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p> 
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">Fecha y hora de inicio</label>

        <input 
            type="datetime-local" 
            wire:model.defer="fecha_inicio" 
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none focus:border-violet-400"
        >

        @error('fecha_inicio') 
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p> 
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">Lugar</label>

        <input 
            type="text" 
            wire:model.defer="lugar" 
            placeholder="Ej: Predio Ferial"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">Ciudad</label>

        <input 
            type="text" 
            wire:model.defer="ciudad" 
            placeholder="Ej: Formosa"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >
    </div>

    <div>
        <label class="mb-2 block text-sm font-bold text-slate-300">Provincia</label>

        <input 
            type="text" 
            wire:model.defer="provincia" 
            placeholder="Ej: Formosa"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        >
    </div>

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-bold text-slate-300">
            Imagen del evento
        </label>

        <input 
            type="file"
            wire:model="imagen_file"
            accept="image/*"
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm text-slate-300 outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-violet-600 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-violet-500"
        >

        @error('imagen_file')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror

        <div wire:loading wire:target="imagen_file" class="mt-2 text-sm text-violet-300">
            Subiendo imagen...
        </div>

        @if($imagen_file)
            <div class="mt-3 overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                <img 
                    src="{{ $imagen_file->temporaryUrl() }}" 
                    alt="Vista previa"
                    class="h-48 w-full object-cover"
                >
            </div>
        @elseif($imagen_url)
            <div class="mt-3 overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                <img 
                    src="{{ asset($imagen_url) }}" 
                    alt="Imagen actual"
                    class="h-48 w-full object-cover"
                >
            </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-bold text-slate-300">Descripción</label>

        <textarea 
            wire:model.defer="descripcion" 
            rows="4" 
            placeholder="Ej: Una noche con artistas en vivo, música y producción de Mora Producciones."
            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
        ></textarea>
    </div>

    <div class="flex items-center gap-3">
        <input type="checkbox" wire:model.defer="mostrar_en_banner" class="rounded border-white/10 bg-white/[0.06]">
        <span class="text-sm text-slate-300">Mostrar en banner principal</span>
    </div>

    <div class="flex items-center gap-3">
        <input type="checkbox" wire:model.defer="mostrar_en_inicio" class="rounded border-white/10 bg-white/[0.06]">
        <span class="text-sm text-slate-300">Mostrar en inicio</span>
    </div>
</div>

<div class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-black text-white">Tipos de entradas</h3>
            <p class="text-sm text-slate-400">
                General y VIP Plata van online. VIP Oro queda solo efectivo.
            </p>
        </div>

        <x-admin.ui.button type="button" variant="secondary" size="sm" wire:click="agregarTipo">
            + Agregar tipo
        </x-admin.ui.button>
    </div>

    <div class="space-y-4">
        @foreach($tipos as $index => $tipo)
            <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                <div class="mb-4 flex items-center justify-between">
                    <p class="font-bold text-white">
                        Entrada #{{ $index + 1 }}
                    </p>

                    <x-admin.ui.button type="button" variant="danger" size="sm" wire:click="quitarTipo({{ $index }})">
                        Quitar
                    </x-admin.ui.button>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <input 
                        type="text" 
                        placeholder="Ej: General, VIP Plata de pie, VIP Oro"
                        wire:model.defer="tipos.{{ $index }}.nombre" 
                        class="rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                    >

                    <input 
                        type="number" 
                        placeholder="Precio. Ej: 15000"
                        wire:model.defer="tipos.{{ $index }}.precio" 
                        class="rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                    >

                    <input 
                        type="number" 
                        placeholder="Stock disponible. Ej: 500"
                        wire:model.defer="tipos.{{ $index }}.stock_disponible" 
                        class="rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                    >

                    <select 
                        wire:model.defer="tipos.{{ $index }}.metodo_pago" 
                        class="rounded-xl border border-white/10 bg-[#111122] px-4 py-3 text-white outline-none focus:border-violet-400"
                    >
                        <option value="qr_mercado_pago">QR Mercado Pago</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="ambos">Ambos</option>
                    </select>

                    <input 
                        type="text" 
                        placeholder="Ubicación / sector. Ej: Sector General"
                        wire:model.defer="tipos.{{ $index }}.ubicacion_descripcion" 
                        class="md:col-span-2 rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                    >

                    <textarea 
                        placeholder="Descripción. Ej: Entrada general con acceso al predio."
                        wire:model.defer="tipos.{{ $index }}.descripcion" 
                        rows="2" 
                        class="md:col-span-3 rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                    ></textarea>

                    <div class="flex flex-wrap gap-5 md:col-span-3">
                        <label class="flex items-center gap-2 text-sm text-slate-300">
                            <input type="checkbox" wire:model.defer="tipos.{{ $index }}.activo">
                            Activa
                        </label>

                        <label class="flex items-center gap-2 text-sm text-slate-300">
                            <input type="checkbox" wire:model.defer="tipos.{{ $index }}.venta_online">
                            Venta online
                        </label>

                        <label class="flex items-center gap-2 text-sm text-slate-300">
                            <input type="checkbox" wire:model.defer="tipos.{{ $index }}.venta_fisica">
                            Venta física
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>