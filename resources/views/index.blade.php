@props([
    'currentView' => 'gifts',
    'categories' => null,
])

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (($currentView ?? '') === 'login')
            Iniciar Sesión
        @elseif (($currentView ?? '') === 'register')
            Crear Cuenta
        @else
            Ideas de Regalos
        @endif
    </title>
    {{-- Aplicar tema oscuro antes del paint para evitar destellos --}}
    <script>
        (function () {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


    <body
        class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased font-sans flex flex-col justify-between transition-colors duration-300">
        <!-- Componente de barra superior de navegación -->
        <x-navbar />

        <!-- Notificación de estado de sesión (ej. bienvenida o despedida) -->
        @if (session('status'))
            <div class="w-full max-w-2xl mx-auto px-4 mt-2">
                <div
                    id="status-notification"
                    class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200
                    dark:border-emerald-700/60 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-medium flex
                    items-center justify-between shadow-xs transition-opacity duration-500 cursor-pointer">
                    <span class="flex items-center gap-2">
                        <span>✨</span>
                        <span>{{ session('status') }}</span>
                    </span>
                </div>
            </div>
        @endif

        <!-- Contenedor principal donde cuelgan el resto de componentes -->
            <main class="w-full max-w-2xl mx-auto px-4 py-8 sm:py-12 grow">
                @if (isset($slot) && $slot->isNotEmpty())
                    {{ $slot }}
                @elseif (($currentView ?? 'gifts') === 'login')
                    <x-login />
                @elseif (($currentView ?? 'gifts') === 'register')
                    <x-register />
                @else
                    @auth
                        @hasSection('content')
                            @yield('content')
                        @else
                            <x-gift-list :categories="$categories ?? null" />
                        @endif
                    @else
                        <x-login />
                    @endauth
                @endif
            </main>

                <footer class="text-center py-6 text-xs text-slate-400 dark:text-slate-600">
                    ¿Qué regalar a mi novix? · Hecho con ❤️ para tu persona favorita.
                </footer>

                <!-- Script para comportamiento de acordeón ("uno a la vez cada vez") -->
                <script>
                    // ── Acordeón ────────────────────────────────────────────────────────
                    document.addEventListener('DOMContentLoaded', () => {
                        const accordion = document.getElementById('gift-accordion');
                        if (!accordion) return;

                        const items = accordion.querySelectorAll('[data-accordion-item]');

                        items.forEach((item) => {
                            const trigger = item.querySelector('[data-accordion-trigger]');
                            if (!trigger) return;

                            trigger.addEventListener('click', () => {
                                const isCurrentlyOpen = item.getAttribute('data-open') === 'true';

                                // 1. Cerrar todos los demás cards (garantiza "uno a la vez")
                                items.forEach((otherItem) => {
                                    otherItem.setAttribute('data-open', 'false');
                                    const otherTrigger = otherItem.querySelector('[data-accordion-trigger]');
                                    if (otherTrigger) {
                                        otherTrigger.setAttribute('aria-expanded', 'false');
                                    }
                                });

                                // 2. Si el actual estaba cerrado, abrirlo. Si ya estaba abierto, cerrarlo.
                                if (!isCurrentlyOpen) {
                                    item.setAttribute('data-open', 'true');
                                    trigger.setAttribute('aria-expanded', 'true');
                                }
                            });
                        });
                    });

                    // ── Notificación: auto-dismiss a los 5s o al hacer click ─────────────
                    document.addEventListener('DOMContentLoaded', () => {
                        const notif = document.getElementById('status-notification');
                        if (!notif) return;

                        const dismiss = () => {
                            notif.classList.add('opacity-0', 'pointer-events-none');
                        };

                        setTimeout(dismiss, 5000);
                        notif.addEventListener('click', dismiss);
                    });

                    // ── Modo oscuro / claro ───────────────────────────────────────────────
                    function toggleDarkMode() {
                        const html = document.documentElement;
                        const isDark = html.classList.toggle('dark');
                        localStorage.setItem('theme', isDark ? 'dark' : 'light');
                        updateThemeIcon(isDark);
                    }

                    function updateThemeIcon(isDark) {
                        const moonIcon = document.getElementById('theme-icon-moon');
                        const sunIcon = document.getElementById('theme-icon-sun');
                        if (!moonIcon || !sunIcon) return;
                        moonIcon.classList.toggle('hidden', isDark);
                        sunIcon.classList.toggle('hidden', !isDark);
                    }

                    // Sincronizar icono al cargar
                    document.addEventListener('DOMContentLoaded', () => {
                        updateThemeIcon(document.documentElement.classList.contains('dark'));
                    });
                </script>
    </body>

</html>