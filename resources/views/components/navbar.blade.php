<!-- Barra superior de autenticación / navegación -->
<nav class="w-full max-w-2xl mx-auto px-4 pt-6 pb-2 flex items-center justify-between">
    <a href="{{ auth()->check() ? route('home') : route('login') }}" class="flex items-center gap-2 group select-none">
            <span
                class="flex items-center justify-center w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 text-base shadow-2xs group-hover:scale-105 transition-transform">
                🎁
            </span>
                <span
                    class="font-extrabold text-slate-800 dark:text-slate-100 text-sm tracking-tight group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                    WishVault
                </span>
    </a>

    <div class="flex items-center gap-2">
        {{-- Botón de alternancia de modo oscuro / claro --}}
        <button type="button" onclick="toggleDarkMode()" title="Cambiar modo claro/oscuro"
            class="flex items-center justify-center w-8 h-8 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-slate-200 transition-colors cursor-pointer">
            {{-- Icono luna (visible en modo claro) --}}
            <svg id="theme-icon-moon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            {{-- Icono sol (visible en modo oscuro) --}}
            <svg id="theme-icon-sun" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
            </svg>
        </button>

        @auth
            <div class="flex items-center gap-2">
                        <div
                            class="flex items-center gap-2 bg-white dark:bg-slate-800 px-3 py-1.5 rounded-full border border-slate-200/80 dark:border-slate-700/80 shadow-2xs">
                            <span
                                class="flex items-center justify-center w-6 h-6 rounded-full bg-rose-100 dark:bg-rose-900/60 text-rose-700 dark:text-rose-400 text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                                <span
                                    class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 max-w-[120px] truncate">
                                    {{ Auth::user()->name }}
                                </span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Cerrar Sesión"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50/60 dark:hover:bg-rose-900/30 transition-all cursor-pointer">
                                <span>Salir</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                </div>
        @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-white dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all select-none">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-xs shadow-rose-600/20 active:scale-95 transition-all select-none">
                        Registrarse
                    </a>
                </div>
            @endauth
        </div>
</nav>