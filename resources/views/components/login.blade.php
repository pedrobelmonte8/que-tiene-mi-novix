<div class="w-full max-w-md mx-auto">
    <!-- Tarjeta del formulario -->
    <div class="rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/50 p-6 sm:p-8">
        <div class="text-center mb-8">
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-rose-50 text-2xl mb-3 shadow-2xs border border-rose-100">
                🔐
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                ¡Hola de nuevo!
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Inicia sesión para ver y gestionar tu lista de regalos
            </p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Campo Correo Electrónico -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Correo electrónico
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="tu@email.com"
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('email') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-800 @enderror text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all"
                >
                @error('email')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Contraseña -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Contraseña
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('password') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-800 @enderror text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all"
                >
                @error('password')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recordarme -->
            <div class="flex items-center justify-between pt-1 pb-2">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-400 cursor-pointer"
                    >
                    <span class="text-xs text-slate-600 font-medium">Recordarme en este equipo</span>
                </label>
            </div>

            <!-- Botón Enviar -->
            <button
                type="submit"
                class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white bg-rose-600 hover:bg-rose-700 active:scale-[0.99] shadow-md shadow-rose-600/20 transition-all cursor-pointer select-none"
            >
                Iniciar Sesión
            </button>
        </form>

        <!-- Enlace a Registro -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                ¿Aún no tienes una cuenta?
                <a
                    href="{{ route('register') }}"
                    class="font-bold text-rose-600 hover:text-rose-700 hover:underline transition-colors"
                >
                    Regístrate gratis
                </a>
            </p>
        </div>
    </div>
</div>

