<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 border-r border-white/10 bg-[#070716] lg:block">
    <div class="flex h-full flex-col px-4 py-5">

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img 
                src="{{ asset('images/mora.jpeg') }}" 
                alt="Mora Producciones" 
                class="h-11 w-11 rounded-xl object-cover"
            >

            <div>
                <p class="text-lg font-black tracking-[0.22em] text-white">
                    MORA
                </p>
                <p class="mt-1 text-[10px] tracking-[0.45em] text-slate-400">
                    PRODUCCIONES
                </p>
            </div>
        </a>

        <p class="mt-5 text-[11px] font-bold uppercase tracking-[0.45em] text-violet-300">
            Panel admin
        </p>

        <nav class="mt-8 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-violet-600/30 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span>▦</span>
                Dashboard
            </a>

            <a href="{{ route('admin.eventos') }}"
   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition
   {{ request()->routeIs('admin.eventos') ? 'bg-violet-600/30 text-white ring-1 ring-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
    <span>▣</span>
    Eventos
</a>
            <a href="{{ route('admin.artistas') }}"
   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition
   {{ request()->routeIs('admin.artistas') ? 'bg-violet-600/30 text-white ring-1 ring-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
    <span>♬</span>
    Artistas
</a>

            <a href="{{ route('admin.ventas') }}"
   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition
   {{ request()->routeIs('admin.ventas') ? 'bg-violet-600/30 text-white ring-1 ring-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
    <span>▤</span>
    Ventas
</a>

            <a href="#"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                <span>⌗</span>
                Validar QR
            </a>

            <a href="#"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                <span>◌</span>
                Usuarios
            </a>

            <a href="#"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                <span>⚙</span>
                Configuración
            </a>
        </nav>

        <div class="mt-auto space-y-3">
            <a href="{{ route('public.inicio') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                <span>⌂</span>
                Volver al sitio
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div class="px-4">
    <button 
        type="submit"
        class="inline-flex items-center gap-2 rounded-xl border border-red-400/30 bg-red-500/10 px-4 py-2 text-sm font-bold text-red-200 transition hover:border-red-300/50 hover:bg-red-500/20 hover:text-white"
    >
        <span class="text-sm"></span>
        Cerrar sesión
    </button>
</div>
            </form>
        </div>
    </div>
</aside>