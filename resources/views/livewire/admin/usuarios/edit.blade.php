<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4 py-8 backdrop-blur-sm">
    <div class="max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-[2rem] border border-white/10 bg-[#080817] p-6 shadow-2xl">

        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-white">
                    Editar usuario
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Modificá los datos, rol o estado del usuario.
                </p>
            </div>

            <x-admin.ui.button variant="ghost" wire:click="cerrarModales">
                ✕
            </x-admin.ui.button>
        </div>

        <form wire:submit.prevent="actualizar" class="space-y-6">
            @include('livewire.admin.usuarios.form-fields')

            <div class="flex justify-end gap-3 border-t border-white/10 pt-5">
                <x-admin.ui.button type="button" variant="secondary" wire:click="cerrarModales">
                    Cancelar
                </x-admin.ui.button>

                <x-admin.ui.button type="submit">
                    Actualizar
                </x-admin.ui.button>
            </div>
        </form>

    </div>
</div>