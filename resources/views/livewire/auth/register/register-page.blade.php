<section class="min-h-screen bg-[#050512] px-4 pt-28 pb-16 text-white sm:px-6 lg:px-8">
    <div class="mx-auto grid max-w-6xl items-center gap-12 lg:grid-cols-2">

        <div class="hidden lg:block">
            <p class="text-xs font-bold uppercase tracking-[0.45em] text-violet-300">
                Mora Producciones
            </p>

            <h1 class="mt-6 text-5xl font-black leading-tight text-white">
                Creá tu cuenta para comprar entradas
            </h1>

            <p class="mt-6 max-w-lg text-lg leading-8 text-slate-400">
                Registrate para acceder a tus entradas, comprobantes y QR de acceso a los eventos.
            </p>

            <div class="mt-10 grid gap-4">
                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-5">
                    <p class="font-bold text-white">Comprá online</p>
                    <p class="mt-2 text-sm text-slate-400">
                        Elegí tu sector y pagá con QR de Mercado Pago.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-5">
                    <p class="font-bold text-white">Recibí tu QR</p>
                    <p class="mt-2 text-sm text-slate-400">
                        Cuando el pago se apruebe, vas a ver tu entrada digital.
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/[0.04] p-6 shadow-2xl shadow-violet-950/30 sm:p-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-black text-white">
                    Crear cuenta
                </h2>

                <p class="mt-3 text-sm text-slate-400">
                    Este registro crea una cuenta de comprador.
                </p>
            </div>

            <form wire:submit.prevent="register" class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Nombre
                        </label>

                        <input
                            type="text"
                            wire:model.defer="nombre"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                            placeholder="Tu nombre"
                        >

                        @error('nombre')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Apellido
                        </label>

                        <input
                            type="text"
                            wire:model.defer="apellido"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                            placeholder="Tu apellido"
                        >

                        @error('apellido')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-300">
                        DNI
                    </label>

                    <input
                        type="text"
                        wire:model.defer="dni"
                        class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                        placeholder="12345678"
                    >

                    @error('dni')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-300">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model.defer="email"
                        class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                        placeholder="tuemail@gmail.com"
                    >

                    @error('email')
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
                        class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                        placeholder="3704..."
                    >

                    @error('telefono')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            wire:model.defer="password"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                            placeholder="Mínimo 8 caracteres"
                        >

                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-300">
                            Repetir contraseña
                        </label>

                        <input
                            type="password"
                            wire:model.defer="password_confirmation"
                            class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                            placeholder="Repetí tu contraseña"
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-violet-600 px-6 py-4 text-sm font-black text-white transition hover:bg-violet-500"
                >
                    Registrarme
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-400">
                ¿Ya tenés cuenta?
                <a href="{{ route('login') }}" class="font-bold text-violet-300 hover:text-violet-200">
                    Iniciar sesión
                </a>
            </p>
        </div>
    </div>
</section>