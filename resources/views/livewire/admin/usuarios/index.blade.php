<section class="mt-6">

    <div class="hidden overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03] lg:block">
        <table class="w-full text-left">
            <thead class="bg-white/[0.03]">
                <tr class="text-xs font-bold uppercase tracking-[0.25em] text-slate-400">
                    <th class="px-4 py-4">Usuario</th>
                    <th class="px-4 py-4">DNI</th>
                    <th class="px-4 py-4">Rol</th>
                    <th class="px-4 py-4">Estado</th>
                    <th class="px-4 py-4">Alta</th>
                    <th class="px-4 py-4 text-center">Compras</th>
                    <th class="px-4 py-4 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/10">
                @forelse($usuarios as $usuario)
                    <tr class="text-sm text-slate-300 transition hover:bg-white/[0.03]">
                        <td class="px-4 py-4">
                            <p class="font-black text-white">
                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                ✉ {{ $usuario->email }}
                            </p>
                        </td>

                        <td class="px-4 py-4">
                            {{ $usuario->dni ?: '—' }}
                        </td>

                        <td class="px-4 py-4">
                            <span class="inline-flex rounded-full border px-3 py-1 text-[11px] font-black uppercase tracking-widest
                                {{ $usuario->rol?->nombre === 'administrador' ? 'border-violet-400/30 bg-violet-500/15 text-violet-300' : 'border-white/10 bg-white/[0.03] text-slate-300' }}">
                                {{ $usuario->rol?->nombre === 'administrador' ? 'Admin' : 'User' }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            @if($usuario->bloqueado)
                                <span class="inline-flex rounded-full border border-red-400/30 bg-red-500/15 px-3 py-1 text-[11px] font-black uppercase tracking-widest text-red-300">
                                    Bloqueado
                                </span>
                            @else
                                <span class="inline-flex rounded-full border border-emerald-400/30 bg-emerald-500/15 px-3 py-1 text-[11px] font-black uppercase tracking-widest text-emerald-300">
                                    Activo
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-4">
                            {{ $usuario->created_at?->format('Y-m-d') }}
                        </td>

                        <td class="px-4 py-4 text-center font-black text-white">
                            {{ $usuario->compras_count }}
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">
                                <x-admin.ui.button size="icon" variant="secondary" wire:click="abrirEditar({{ $usuario->id }})">
                                    ✎
                                </x-admin.ui.button>

                                <x-admin.ui.button 
                                    size="icon" 
                                    variant="secondary" 
                                    wire:click="cambiarBloqueo({{ $usuario->id }})"
                                    wire:confirm="¿Seguro que querés cambiar el estado de este usuario?"
                                >
                                    ⊘
                                </x-admin.ui.button>

                                <x-admin.ui.button 
                                    size="icon" 
                                    variant="danger" 
                                    wire:click="eliminar({{ $usuario->id }})"
                                    wire:confirm="¿Seguro que querés eliminar este usuario?"
                                >
                                    🗑
                                </x-admin.ui.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center text-slate-400">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $usuarios->links() }}
    </div>
</section>