<div class="w-full max-w-md mx-auto">
    <!-- Tarjeta del formulario -->
    <div class="rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/50 p-6 sm:p-8">
        <div class="text-center mb-8">
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-rose-50 text-2xl mb-3 shadow-2xs border border-rose-100">
                ✨
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Crea tu cuenta
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Guarda tus ideas favoritas y nunca olvides un regalo
            </p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Campo Nombre -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Nombre completo
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Tu nombre o apodo"
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('name') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-800 @enderror text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all"
                >
                @error('name')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Nombre de la Primera Lista -->
            <div>
                <label for="first_list_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Nombre de tu primera lista <span class="text-rose-600">*</span>
                </label>
                <input
                    type="text"
                    id="first_list_name"
                    name="first_list_name"
                    value="{{ old('first_list_name') }}"
                    required
                    placeholder="Ej. Mi novix, Cumpleaños de Lucas, Ideas Navidad..."
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('first_list_name') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-800 @enderror text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all"
                >
                @error('first_list_name')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

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
                    Contraseña (mínimo 8 caracteres)
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl border @error('password') border-rose-400 bg-rose-50/30 text-rose-900 @else border-slate-200 bg-slate-50/50 text-slate-800 @enderror text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all"
                >
                @error('password')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Confirmar Contraseña
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all"
                >
            </div>

            <!-- Botón Enviar -->
            <button
                type="submit"
                class="w-full py-3 px-4 mt-2 rounded-xl font-bold text-sm text-white bg-rose-600 hover:bg-rose-700 active:scale-[0.99] shadow-md shadow-rose-600/20 transition-all cursor-pointer select-none"
            >
                Crear mi Cuenta
            </button>
        </form>

        <!-- Enlace a Login -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                ¿Ya tienes una cuenta?
                <a
                    href="{{ route('login') }}"
                    class="font-bold text-rose-600 hover:text-rose-700 hover:underline transition-colors"
                >
                    Inicia sesión aquí
                </a>
            </p>
        </div>
    </div>
</div>

