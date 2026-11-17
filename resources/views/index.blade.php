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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased font-sans flex flex-col justify-between">
    <!-- Componente de barra superior de navegación -->
    <x-navbar />

    <!-- Notificación de estado de sesión (ej. bienvenida o despedida) -->
    @if (session('status'))
        <div class="w-full max-w-2xl mx-auto px-4 mt-2">
            <div
                class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center justify-between shadow-xs">
                <span class="flex items-center gap-2">
                    <span>✨</span>
                    <span>{{ session('status') }}</span>
                </span>
            </div>
        </div>
    @endif

    <!-- Contenedor principal donde cuelgan el resto de componentes -->
    <main class="w-full max-w-2xl mx-auto px-4 py-8 sm:py-12">
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

    <footer class="text-center py-6 text-xs text-slate-400">
        ¿Qué regalar a mi novix? · Hecho con ❤️ para tu persona favorita.
    </footer>

    <!-- Script para comportamiento de acordeón ("uno a la vez cada vez") -->
    <script>
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
    </script>
</body>

</html>