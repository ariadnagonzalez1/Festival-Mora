<section class="min-h-screen bg-[#050512] px-4 pt-28 pb-16 text-white sm:px-6 lg:px-8">
    <div class="mx-auto grid max-w-6xl items-center gap-12 lg:grid-cols-2">

        <div class="hidden lg:block">
            <p class="text-xs font-bold uppercase tracking-[0.45em] text-violet-300">
                Mora Producciones
            </p>

            <h1 class="mt-6 text-5xl font-black leading-tight text-white">
                Ingresá y viví la experiencia Mora
            </h1>

            <p class="mt-6 max-w-lg text-lg leading-8 text-slate-400">
                Accedé a tus compras, entradas digitales y códigos QR para ingresar a los eventos.
            </p>

            <div class="mt-10 rounded-3xl border border-white/10 bg-white/[0.03] p-6">
                <p class="text-sm text-slate-300">
                    Si todavía no tenés cuenta, registrate para poder comprar entradas online.
                </p>
            </div>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/[0.04] p-6 shadow-2xl shadow-violet-950/30 sm:p-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-black text-white">
                    Iniciar sesión
                </h2>

                <p class="mt-3 text-sm text-slate-400">
                    Entrá con tu email y contraseña.
                </p>
            </div>

            <form wire:submit.prevent="login" class="space-y-5">
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
                        Contraseña
                    </label>

                    <input
                        type="password"
                        wire:model.defer="password"
                        class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-violet-400"
                        placeholder="••••••••"
                    >

                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-violet-600 px-6 py-4 text-sm font-black text-white transition hover:bg-violet-500"
                >
                    Ingresar
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-400">
                ¿No tenés cuenta?
                <a href="{{ route('register') }}" class="font-bold text-violet-300 hover:text-violet-200">
                    Registrarme
                </a>
            </p>
        </div>
    </div>
</section>