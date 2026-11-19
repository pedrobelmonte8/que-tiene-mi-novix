<!-- Modal para Crear / Modificar Artículos -->
@props(['activeList' => null])
<div id="gift-modal"
    class="fixed inset-0 z-100 hidden items-center justify-center p-4 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity duration-200"
    role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div id="gift-modal-card"
        class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 p-6 sm:p-7 shadow-2xl border border-slate-200 dark:border-slate-700/80 transform transition-all duration-200 scale-95 opacity-0">
        <!-- Cabecera del Modal -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span id="modal-icon" class="text-2xl select-none">🎁</span>
                        <h3 id="modal-title" class="text-lg sm:text-xl font-black text-slate-900 dark:text-slate-100">
                            Añadir nuevo artículo
                        </h3>
                </div>
                <button type="button" onclick="closeGiftModal()"
                    class="flex items-center justify-center w-8 h-8 rounded-full text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer select-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Formulario Crear / Editar -->
            <form id="gift-modal-form" method="POST" action="{{ route('gifts.store') }}" class="space-y-4 pt-4">
                @csrf
                <input type="hidden" name="_method" id="gift-modal-method" value="POST">
                <input type="hidden" name="category" id="gift-modal-category" value="ropa">
                <input type="hidden" name="gift_list_id" id="gift-modal-list-id" value="{{ $activeList?->id }}">

                <!-- Categoría Selector visible si se desea cambiar -->
                <div>
                        <label for="gift-modal-category-select"
                            class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                            Categoría
                        </label>
                        <select id="gift-modal-category-select"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white dark:focus:bg-slate-700 transition-all font-medium cursor-pointer"
                            onchange="document.getElementById('gift-modal-category').value = this.value">
                            @foreach (\App\Models\Gift::CATEGORIES as $catKey => $catData)
                                <option value="{{ $catKey }}">
                                    {{ $catData['icon'] }} {{ $catData['title'] }}
                                </option>
                            @endforeach
                        </select>
                </div>

                <!-- Nombre del Artículo -->
                <div>
                        <label for="gift-modal-name"
                            class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                            Nombre del artículo <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="gift-modal-name" name="name" required
                            placeholder="Ej. Sudadera Oversize, Perfume, Set LEGO..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white dark:focus:bg-slate-700 transition-all">
                </div>

                <!-- Fila con Precio y Dónde Comprar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                            <label for="gift-modal-price"
                                class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                                Precio aprox.
                            </label>
                            <input type="text" id="gift-modal-price" name="price" placeholder="Ej. 29,99 € o ~$50"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white dark:focus:bg-slate-700 transition-all">
                    </div>

                    <div>
                            <label for="gift-modal-store"
                                class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                                Dónde comprar
                            </label>
                            <input type="text" id="gift-modal-store" name="store"
                                placeholder="Ej. Zara, Sephora, Amazon..."
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white dark:focus:bg-slate-700 transition-all">
                    </div>
                </div>

                <!-- Prioridad / Etiqueta sugerida -->
                <div>
                        <label for="gift-modal-badge"
                            class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                            Prioridad / Etiqueta
                        </label>
                        <div class="relative">
                            <input type="text" id="gift-modal-badge" name="badge"
                                placeholder="Ej. ⭐ Top Deseo, Prioridad Alta, Deseado, Detalle..."
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white dark:focus:bg-slate-700 transition-all">
                        </div>
                        <!-- Botones rápidos de etiquetas -->
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            <button type="button" onclick="setGiftBadge('⭐ Top Deseo')"
                                class="px-2 py-0.5 rounded-md text-2xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 transition-colors cursor-pointer">
                                ⭐ Top Deseo
                            </button>
                            <button type="button" onclick="setGiftBadge('Prioridad Alta')"
                                class="px-2 py-0.5 rounded-md text-2xs font-semibold bg-amber-50 text-amber-800 hover:bg-amber-100 transition-colors cursor-pointer">
                                Prioridad Alta
                            </button>
                            <button type="button" onclick="setGiftBadge('Deseado')"
                                class="px-2 py-0.5 rounded-md text-2xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors cursor-pointer">
                                Deseado
                            </button>
                            <button type="button" onclick="setGiftBadge('Sentimental 🥹')"
                                class="px-2 py-0.5 rounded-md text-2xs font-semibold bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors cursor-pointer">
                                Sentimental 🥹
                            </button>
                        </div>
                </div>

                <!-- Notas / Detalles -->
                <div>
                        <label for="gift-modal-note"
                            class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                            Notas y detalles (tallas, tonos, colores, tips)
                        </label>
                        <textarea id="gift-modal-note" name="note" rows="2"
                            placeholder="Ej. Talla M, le encantan los tonos tierra o verde oliva. Ojalá de algodón..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 focus:bg-white dark:focus:bg-slate-700 transition-all resize-none"></textarea>
                </div>

                <!-- Botones de Acción -->
                    <div
                        class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" onclick="closeGiftModal()"
                            class="px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer select-none">
                            Cancelar
                        </button>
                        <button type="submit" id="gift-modal-submit-btn"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-rose-600 hover:bg-rose-700 active:scale-95 shadow-md shadow-rose-600/20 transition-all cursor-pointer select-none">
                            Guardar artículo
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        function setGiftBadge(badgeText) {
            document.getElementById('gift-modal-badge').value = badgeText;
        }

        function openCreateGiftModal(categoryKey, categoryTitle, categoryIcon) {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-modal-card');
            const form = document.getElementById('gift-modal-form');
            const methodInput = document.getElementById('gift-modal-method');
            const title = document.getElementById('modal-title');
            const icon = document.getElementById('modal-icon');
            const categoryInput = document.getElementById('gift-modal-category');
            const categorySelect = document.getElementById('gift-modal-category-select');
            const submitBtn = document.getElementById('gift-modal-submit-btn');

            // Configuración para CREAR
            form.action = "{{ route('gifts.store') }}";
            methodInput.value = "POST";
            title.textContent = `Añadir a ${categoryTitle}`;
            icon.textContent = categoryIcon || '🎁';
            submitBtn.textContent = 'Guardar artículo';

            categoryInput.value = categoryKey;
            if (categorySelect) categorySelect.value = categoryKey;

            // Limpiar campos
            document.getElementById('gift-modal-name').value = '';
            document.getElementById('gift-modal-price').value = '';
            document.getElementById('gift-modal-store').value = '';
            document.getElementById('gift-modal-badge').value = '';
            document.getElementById('gift-modal-note').value = '';

            // Mostrar con animación
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
                document.getElementById('gift-modal-name').focus();
            }, 10);
        }

        function openEditGiftModal(gift) {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-modal-card');
            const form = document.getElementById('gift-modal-form');
            const methodInput = document.getElementById('gift-modal-method');
            const title = document.getElementById('modal-title');
            const icon = document.getElementById('modal-icon');
            const categoryInput = document.getElementById('gift-modal-category');
            const categorySelect = document.getElementById('gift-modal-category-select');
            const submitBtn = document.getElementById('gift-modal-submit-btn');

            // Configuración para MODIFICAR
            form.action = `/gifts/${gift.id}`;
            methodInput.value = "PUT";
            title.textContent = 'Modificar artículo';
            icon.textContent = '✏️';
            submitBtn.textContent = 'Guardar cambios';

            categoryInput.value = gift.category;
            if (categorySelect) categorySelect.value = gift.category;

            // Llenar campos con los datos existentes
            document.getElementById('gift-modal-name').value = gift.name || '';
            document.getElementById('gift-modal-price').value = gift.price || '';
            document.getElementById('gift-modal-store').value = gift.store || '';
            document.getElementById('gift-modal-badge').value = gift.badge || '';
            document.getElementById('gift-modal-note').value = gift.note || '';

            // Mostrar con animación
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
                document.getElementById('gift-modal-name').focus();
            }, 10);
        }

        function closeGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-modal-card');
            if (!modal || !card) return;

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 150);
        }

        // Cerrar al hacer clic fuera de la tarjeta o presionar Esc
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeGiftModal();
        });

        document.getElementById('gift-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'gift-modal') closeGiftModal();
        });
    </script>