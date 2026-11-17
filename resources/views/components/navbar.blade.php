<!-- Barra superior de autenticación / navegación -->
<nav class="w-full max-w-2xl mx-auto px-4 pt-6 pb-2 flex items-center justify-between">
    <a href="{{ auth()->check() ? route('home') : route('login') }}" class="flex items-center gap-2 group select-none">
        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-rose-100 text-rose-600 text-base shadow-2xs group-hover:scale-105 transition-transform">
            🎁
        </span>
        <span class="font-extrabold text-slate-800 text-sm tracking-tight group-hover:text-rose-600 transition-colors">
            NovixGifts
        </span>
    </a>

    <div class="flex items-center gap-2">
        @auth
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full border border-slate-200/80 shadow-2xs">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-rose-100 text-rose-700 text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="text-xs sm:text-sm font-semibold text-slate-700 max-w-[120px] truncate">
                        {{ Auth::user()->name }}
                    </span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button
                        type="submit"
                        title="Cerrar Sesión"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-500 hover:text-rose-600 hover:bg-rose-50/60 transition-all cursor-pointer"
                    >
                        <span>Salir</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        @else
            <div class="flex items-center gap-2">
                <a
                    href="{{ route('login') }}"
                    class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-rose-600 hover:bg-white border border-transparent hover:border-slate-200 transition-all select-none"
                >
                    Iniciar Sesión
                </a>
                <a
                    href="{{ route('register') }}"
                    class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs shadow-rose-600/20 active:scale-95 transition-all select-none"
                >
                    Registrarse
                </a>
            </div>
        @endauth
    </div>
</nav>

