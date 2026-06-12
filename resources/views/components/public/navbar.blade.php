<header class="fixed top-0 left-0 right-0 z-50 border-b border-white/10 bg-[#070716]/90 backdrop-blur-xl">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <a href="{{ route('public.inicio') }}" class="flex items-center gap-3">
    <img 
        src="{{ asset('images/mora.jpeg') }}" 
        alt="Mora Producciones" 
        class="h-10 w-10 rounded-xl object-cover"
    >

    <div class="leading-none">
        <p class="text-lg font-black tracking-[0.22em] text-white">
            MORA
        </p>
        <p class="mt-1 text-[10px] tracking-[0.45em] text-slate-400">
            PRODUCCIONES
        </p>
    </div>
</a>

        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ route('public.inicio') }}"
               class="text-sm font-semibold text-white transition hover:text-violet-300">
                Inicio
            </a>

            <a href="{{ route('public.eventos') }}"
               class="text-sm font-medium text-slate-400 transition hover:text-white">
                Eventos
            </a>

            <a href="{{ route('public.experiencias') }}"
               class="text-sm font-medium text-slate-400 transition hover:text-white">
                Experiencias Mora
            </a>
        </nav>

        <div class="hidden items-center gap-4 md:flex">
    @auth
        <span class="text-sm font-semibold text-slate-300">
            {{ auth()->user()->nombre }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="rounded-lg border border-white/10 px-4 py-2 text-sm font-bold text-white transition hover:bg-white/10"
            >
                Salir
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-violet-300">
            Ingresar
        </a>

        <a href="{{ route('register') }}"
           class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-violet-500">
            Registrarme
        </a>
    @endauth
</div>

        <button class="md:hidden rounded-lg border border-white/10 px-3 py-2 text-sm text-white">
            Menú
        </button>
    </div>
</header>