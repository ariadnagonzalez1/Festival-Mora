<div class="min-h-screen bg-[#050512] pb-10 text-white">

    {{-- HEADER --}}
    <div>
        <h1 class="text-4xl font-black text-white">
            Configuración
        </h1>

        <p class="mt-2 text-slate-400">
            Configurá los datos de Mora, la cuenta de Mercado Pago, notificaciones y seguridad.
        </p>
    </div>

    {{-- MENSAJES --}}
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

    <form wire:submit.prevent="guardarConfiguracion" class="mt-8 space-y-6">

        <div class="grid gap-6 xl:grid-cols-2">

            {{-- DATOS DE MORA --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white">
                        Datos de Mora
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Estos datos se usan como información pública de la productora.
                    </p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Nombre comercial
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="nombre_comercial"
                            placeholder="Ej: Mora Producciones"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        @error('nombre_comercial')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Razón social
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="razon_social"
                            placeholder="Ej: Mora Producciones S.R.L."
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            CUIT
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="cuit"
                            placeholder="Ej: 30-71234567-8"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Email de contacto
                        </label>

                        <input 
                            type="email" 
                            wire:model.defer="email_contacto"
                            placeholder="hola@moraproducciones.ar"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        @error('email_contacto')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Teléfono
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="telefono"
                            placeholder="Ej: +54 3704..."
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Dirección
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="direccion"
                            placeholder="Ej: Formosa, Argentina"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Bio pública
                        </label>

                        <textarea 
                            wire:model.defer="bio_publica"
                            rows="4"
                            placeholder="Productora de eventos, festivales y experiencias en vivo..."
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        ></textarea>
                    </div>
                </div>
            </section>

            {{-- MERCADO PAGO --}}
            <section class="rounded-3xl border border-violet-400/20 bg-violet-500/10 p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white">
                        Mercado Pago para QR
                    </h2>

                    <p class="mt-1 text-sm text-slate-300">
                        Estos datos conectan los QR de las entradas con la cuenta de Mercado Pago que va a cobrar.
                    </p>
                </div>

                <div class="mb-5 rounded-2xl border border-yellow-400/20 bg-yellow-500/10 p-4 text-sm text-yellow-100">
                    Para que el QR cobre a Mora, lo importante es el <strong>Access Token</strong> de la cuenta de Mora y el <strong>POS External ID</strong>.  
                    El alias, CBU o CVU no se usan para generar el QR de Mercado Pago.
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Nombre receptor
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="nombre_receptor"
                            placeholder="Ej: Mora Producciones"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Es el nombre que vas a mostrar en el sistema como cuenta receptora.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Public Key
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="public_key"
                            placeholder="APP_USR-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxx"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Se usa para integraciones del lado público si después agregamos checkout o SDK.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Access Token
                        </label>

                        <input 
                            type="password" 
                            wire:model.defer="access_token"
                            placeholder="APP_USR-xxxxxxxxxxxxxxxx"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Dato sensible. No se muestra el token guardado. Si escribís uno nuevo, se reemplaza.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            POS External ID
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="pos_external_id"
                            placeholder="Ej: MORA_CAJA_001"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Es la caja o punto de venta creado en Mercado Pago para generar los QR.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Webhook URL
                        </label>

                        <input 
                            type="text" 
                            wire:model.defer="webhook_url"
                            placeholder="https://tudominio.com/api/mercado-pago/webhook"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Más adelante Mercado Pago va a avisar acá cuando el pago se apruebe.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Webhook Secret
                        </label>

                        <input 
                            type="password" 
                            wire:model.defer="webhook_secret"
                            placeholder="Dejar vacío para mantener el actual"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-violet-400"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Opcional. Sirve para validar que los avisos realmente vienen de Mercado Pago.
                        </p>
                    </div>

                    <label class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-black/20 p-4">
                        <div>
                            <p class="font-bold text-white">
                                Modo sandbox
                            </p>

                            <p class="text-sm text-slate-400">
                                Activar para hacer pruebas sin cobrar dinero real.
                            </p>
                        </div>

                        <input 
                            type="checkbox" 
                            wire:model.defer="modo_sandbox"
                            class="h-5 w-5 rounded border-white/10 bg-white/[0.06]"
                        >
                    </label>
                </div>
            </section>

            {{-- NOTIFICACIONES --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white">
                        Notificaciones
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Automatizaciones para compras, entradas y stock.
                    </p>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-black/20 p-4">
                        <div>
                            <p class="font-bold text-white">
                                Email al comprador con la entrada
                            </p>

                            <p class="text-sm text-slate-400">
                                Se enviará cuando el pago esté aprobado.
                            </p>
                        </div>

                        <input 
                            type="checkbox" 
                            wire:model.defer="email_comprador_confirmacion"
                            class="h-5 w-5 rounded border-white/10 bg-white/[0.06]"
                        >
                    </label>

                    <label class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-black/20 p-4">
                        <div>
                            <p class="font-bold text-white">
                                Email al admin por cada venta
                            </p>

                            <p class="text-sm text-slate-400">
                                Mora recibe aviso cuando entra una nueva compra.
                            </p>
                        </div>

                        <input 
                            type="checkbox" 
                            wire:model.defer="email_admin_nueva_compra"
                            class="h-5 w-5 rounded border-white/10 bg-white/[0.06]"
                        >
                    </label>

                    <label class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-black/20 p-4">
                        <div>
                            <p class="font-bold text-white">
                                Recordatorio 24h antes del evento
                            </p>

                            <p class="text-sm text-slate-400">
                                Aviso automático al comprador antes del evento.
                            </p>
                        </div>

                        <input 
                            type="checkbox" 
                            wire:model.defer="recordatorio_24hs_comprador"
                            class="h-5 w-5 rounded border-white/10 bg-white/[0.06]"
                        >
                    </label>

                    <label class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-black/20 p-4">
                        <div>
                            <p class="font-bold text-white">
                                Alerta por bajo stock
                            </p>

                            <p class="text-sm text-slate-400">
                                Aviso cuando quedan pocas entradas disponibles.
                            </p>
                        </div>

                        <input 
                            type="checkbox" 
                            wire:model.defer="alerta_bajo_stock_admin"
                            class="h-5 w-5 rounded border-white/10 bg-white/[0.06]"
                        >
                    </label>
                </div>
            </section>

            {{-- SEGURIDAD --}}
            <section class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white">
                        Seguridad
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Cambiá la contraseña del usuario administrador logueado.
                    </p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Contraseña actual
                        </label>

                        <input 
                            type="password" 
                            wire:model.defer="password_actual"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none focus:border-violet-400"
                        >

                        @error('password_actual')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Nueva contraseña
                        </label>

                        <input 
                            type="password" 
                            wire:model.defer="password_nueva"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none focus:border-violet-400"
                        >

                        @error('password_nueva')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Confirmar nueva contraseña
                        </label>

                        <input 
                            type="password" 
                            wire:model.defer="password_nueva_confirmation"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none focus:border-violet-400"
                        >
                    </div>

                    <x-admin.ui.button type="button" variant="secondary" wire:click="cambiarPassword">
                        Cambiar contraseña
                    </x-admin.ui.button>
                </div>
            </section>

        </div>

        {{-- GUARDAR CONFIG --}}
        <div class="sticky bottom-0 mt-8 flex justify-end border-t border-white/10 bg-[#050512]/90 py-5 backdrop-blur-xl">
            <x-admin.ui.button type="submit" size="lg">
                Guardar cambios
            </x-admin.ui.button>
        </div>

    </form>

</div>