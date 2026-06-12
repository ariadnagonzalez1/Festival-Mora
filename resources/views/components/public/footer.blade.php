<footer class="border-t border-white/10 bg-[#050512] px-4 py-14 sm:px-6 lg:px-8">
    <div class="mx-auto grid max-w-7xl gap-10 md:grid-cols-3">

        <div>
            <div class="flex items-center gap-3">
<img 
    src="{{ asset('images/mora.jpeg') }}" 
    alt="Mora Producciones" 
    class="h-12 w-12 rounded-xl object-cover"
>                <div>
                    <p class="text-lg font-black tracking-[0.22em]">MORA</p>
                    <p class="text-[10px] tracking-[0.45em] text-slate-400">PRODUCCIONES</p>
                </div>
            </div>

            <p class="mt-6 max-w-sm text-sm leading-6 text-slate-400">
                Productora de eventos y festivales. Creamos experiencias inolvidables con música, producción y arte.
            </p>
        </div>

        <div>
            <h3 class="text-xs font-bold uppercase tracking-[0.35em] text-slate-400">
                Contacto
            </h3>

            <div class="mt-5 space-y-3 text-sm text-slate-300">
                <p>hola@moraproducciones.ar</p>
                <p>+54 11 5555 0100</p>
                <p>Buenos Aires, Argentina</p>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-bold uppercase tracking-[0.35em] text-slate-400">
                Enlaces
            </h3>

            <div class="mt-5 space-y-3 text-sm text-slate-300">
                <p><a href="{{ route('public.eventos') }}" class="hover:text-white">Eventos</a></p>
                <p><a href="{{ route('public.experiencias') }}" class="hover:text-white">Experiencias Mora</a></p>
                <p><a href="#" class="hover:text-white">Términos y condiciones</a></p>
                <p><a href="#" class="hover:text-white">Política de privacidad</a></p>
            </div>
        </div>
    </div>

    <div class="mx-auto mt-12 max-w-7xl border-t border-white/10 pt-6 text-center text-sm text-slate-500">
        © {{ date('Y') }} Mora Producciones — Todos los derechos reservados
    </div>
</footer>