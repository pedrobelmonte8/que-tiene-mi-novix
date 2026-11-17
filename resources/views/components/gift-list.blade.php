@props(['categories' => null])

@php
    $categories = $categories ?? [
        [
            'id' => 'ropa',
            'icon' => '👗',
            'title' => 'Ropa y Calzado',
            'tag' => 'Moda & Accesorios',
            'tag_color' => 'bg-pink-100 text-pink-800 border-pink-200',
            'items' => [
                [
                    'name' => 'Sudadera Oversize con Capucha',
                    'price' => '39,99 €',
                    'store' => 'Zara / Uniqlo',
                    'note' => 'Talla M. Prefiere colores neutros (beige, gris claro o verde oliva). Con tela suave por dentro.',
                    'badge' => '⭐ Prioridad Alta',
                    'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
                ],
                [
                    'name' => 'Zapatillas Casual Blancas',
                    'price' => '85,00 €',
                    'store' => 'Adidas / Foot Locker',
                    'note' => 'Talla 39. Modelo clásico básico que combine con vaqueros o vestidos.',
                    'badge' => 'Deseado',
                    'badge_color' => 'bg-slate-100 text-slate-700 border-slate-200',
                ],
                [
                    'name' => 'Bufanda de Lana Gruesa',
                    'price' => '22,50 €',
                    'store' => 'Mango / Pull&Bear',
                    'note' => 'Que no pique, suave y calentita para invierno.',
                    'badge' => 'Detalle',
                    'badge_color' => 'bg-rose-50 text-rose-700 border-rose-200',
                ],
            ],
        ],
        [
            'id' => 'maquillaje',
            'icon' => '💄',
            'title' => 'Maquillaje & Belleza',
            'tag' => 'Beauty',
            'tag_color' => 'bg-rose-100 text-rose-800 border-rose-200',
            'items' => [
                [
                    'name' => 'Gloss Labial Hidratante Gloss Bomb',
                    'price' => '24,00 €',
                    'store' => 'Sephora (Fenty Beauty)',
                    'note' => 'Tono "Fenty Glow" o "Fu$$y". Le encanta que no quede pegajoso y huela a vainilla.',
                    'badge' => '⭐ Top Deseo',
                    'badge_color' => 'bg-rose-100 text-rose-800 border-rose-200',
                ],
                [
                    'name' => 'Colorete Líquido Soft Pinch',
                    'price' => '27,90 €',
                    'store' => 'Sephora (Rare Beauty)',
                    'note' => 'Tono "Hope" o "Happy" (acabado jugoso). Dice que dura todo el día con una sola gota.',
                    'badge' => 'Favorito',
                    'badge_color' => 'bg-pink-100 text-pink-700 border-pink-200',
                ],
            ],
        ],
        [
            'id' => 'cremas',
            'icon' => '🧴',
            'title' => 'Cremas & Skincare',
            'tag' => 'Cuidado Personal',
            'tag_color' => 'bg-teal-100 text-teal-800 border-teal-200',
            'items' => [
                [
                    'name' => 'Sérum Ácido Hialurónico + B5',
                    'price' => '12,90 €',
                    'store' => 'Primor / Druni (The Ordinary)',
                    'note' => 'Usa este religiosamente después de lavarse la cara por la mañana. Se le está agotando.',
                    'badge' => 'Necesario',
                    'badge_color' => 'bg-teal-100 text-teal-800 border-teal-200',
                ],
                [
                    'name' => 'Crema Hidratante Ultra Facial Cream',
                    'price' => '36,00 €',
                    'store' => 'Kiehl’s / El Corte Inglés',
                    'note' => 'Textura ligera para piel mixta, sin aroma fuerte.',
                    'badge' => 'Deseado',
                    'badge_color' => 'bg-slate-100 text-slate-700 border-slate-200',
                ],
            ],
        ],
        [
            'id' => 'comida',
            'icon' => '🍣',
            'title' => 'Comida & Experiencias Gastro',
            'tag' => 'Gourmet',
            'tag_color' => 'bg-amber-100 text-amber-800 border-amber-200',
            'items' => [
                [
                    'name' => 'Cena Menú Degustación de Sushi o Ramen',
                    'price' => '~55,00 €',
                    'store' => 'Restaurante japonés favorito del centro',
                    'note' => 'Hacer reserva sorpresa para viernes noche. Pedir mesa tranquila.',
                    'badge' => '⭐ Cita Romántica',
                    'badge_color' => 'bg-amber-100 text-amber-800 border-amber-200',
                ],
                [
                    'name' => 'Caja de Bombones Belgas Artesanales',
                    'price' => '16,50 €',
                    'store' => 'Pastelería local / Leonidas',
                    'note' => 'Solo chocolate negro y praliné (sin naranja ni menta).',
                    'badge' => 'Detalle dulce',
                    'badge_color' => 'bg-orange-100 text-orange-800 border-orange-200',
                ],
            ],
        ],
        [
            'id' => 'juguetes',
            'icon' => '🎮',
            'title' => 'Juguetes, Juegos & Hobbies',
            'tag' => 'Entretenimiento',
            'tag_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'items' => [
                [
                    'name' => 'Set LEGO Flores Botánicas (Orquídea)',
                    'price' => '44,99 €',
                    'store' => 'Amazon / LEGO Store',
                    'note' => 'Para armarlo juntos un domingo por la tarde y dejarlo de adorno en su escritorio.',
                    'badge' => '⭐ Top Deseo',
                    'badge_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                ],
                [
                    'name' => 'Juego de Cartas Cooperativo (The Mind / Codenames)',
                    'price' => '15,00 €',
                    'store' => 'Zacatrus / Librería',
                    'note' => 'Ideal para jugar de a 2 en viajes o cafés.',
                    'badge' => 'Para jugar juntos',
                    'badge_color' => 'bg-slate-100 text-slate-700 border-slate-200',
                ],
            ],
        ],
        [
            'id' => 'otros',
            'icon' => '🎁',
            'title' => 'Otros & Detalles Especiales',
            'tag' => 'Sorpresas',
            'tag_color' => 'bg-purple-100 text-purple-800 border-purple-200',
            'items' => [
                [
                    'name' => 'Álbum Fotográfico con Recuerdos del Año',
                    'price' => '24,00 €',
                    'store' => 'Cheerz / Hoffman (Online)',
                    'note' => 'Incluir fotos de viajes y anécdotas escritas a mano con stickers.',
                    'badge' => 'Sentimental 🥹',
                    'badge_color' => 'bg-purple-100 text-purple-800 border-purple-200',
                ],
                [
                    'name' => 'Vela Aromática de Soja (Vainilla & Sándalo)',
                    'price' => '18,50 €',
                    'store' => 'Zara Home / Rituals',
                    'note' => 'Para prender cuando lee o se baña. Vaso bonito reutilizable.',
                    'badge' => 'Relax',
                    'badge_color' => 'bg-rose-50 text-rose-700 border-rose-200',
                ],
            ],
        ],
    ];
@endphp

<div>
    <!-- Encabezado de la lista -->
    <header class="text-center mb-10">
        <span
            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-700 mb-3 shadow-xs border border-rose-200">
            🎁 Lista de Deseos & Regalos
        </span>
        <p class="text-slate-500 text-sm sm:text-base max-w-lg mx-auto">
            Ideas organizadas por categorías con precios, tiendas y notas secretas. Toca cada tarjeta para ver los
            artículos.
        </p>
    </header>

    <!-- Contenedor de cards apiladas en cascada (la última está más adelante) -->
    <div class="relative flex flex-col pt-2 pb-10" id="gift-accordion">
        @foreach ($categories as $index => $category)
            @php
                $isOpen = $loop->first;
                $zIndex = ($index + 1) * 10;
                $itemsCount = count($category['items']);
            @endphp

            <article data-accordion-item data-open="{{ $isOpen ? 'true' : 'false' }}" style="z-index: {{ $zIndex }};"
                class="relative group rounded-2xl bg-white border border-slate-200/90 shadow-[0_-3px_10px_rgba(0,0,0,0.04),0_6px_14px_rgba(0,0,0,0.06)] transition-all duration-300 first:mt-0 -mt-4 sm:-mt-5 hover:-translate-y-1 hover:border-slate-300 data-[open=true]:translate-y-0 data-[open=true]:border-rose-400 data-[open=true]:ring-4 data-[open=true]:ring-rose-100/70 data-[open=true]:shadow-xl">
                <!-- Cabecera / Categoría (siempre visible) -->
                <button type="button" data-accordion-trigger aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left cursor-pointer select-none focus:outline-hidden">
                    <div class="flex items-center gap-3.5 min-w-0 pr-3">
                        <span
                            class="shrink-0 flex items-center justify-center w-11 h-11 rounded-xl bg-slate-100 text-2xl group-hover:scale-105 group-data-[open=true]:bg-rose-100 transition-all duration-300 shadow-xs">
                            {{ $category['icon'] }}
                        </span>
                        <div class="truncate">
                            <div class="flex items-center gap-2">
                                <h2
                                    class="text-base sm:text-lg font-bold text-slate-800 group-data-[open=true]:text-rose-600 transition-colors duration-200 truncate">
                                    {{ $category['title'] }}
                                </h2>
                                <span
                                    class="hidden sm:inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold {{ $category['tag_color'] }}">
                                    {{ $category['tag'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $itemsCount }} {{ $itemsCount === 1 ? 'artículo guardado' : 'artículos guardados' }}
                            </p>
                        </div>
                    </div>

                    <!-- Badge con contador y flecha giratoria -->
                    <div class="shrink-0 flex items-center gap-2.5">
                        <span
                            class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 group-data-[open=true]:bg-rose-100 group-data-[open=true]:text-rose-700 transition-colors">
                            {{ $itemsCount }} ideas
                        </span>
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 group-hover:text-slate-600 group-data-[open=true]:text-rose-500 group-data-[open=true]:rotate-180 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </button>

                <!-- Lista de Artículos desplegable -->
                <div
                    class="grid transition-all duration-300 ease-in-out group-data-[open=true]:grid-rows-[1fr] group-data-[open=false]:grid-rows-[0fr]">
                    <div class="overflow-hidden">
                        <div class="p-4 sm:p-6 pt-0 pb-7 sm:pb-8 border-t border-slate-100 space-y-4">
                            <div class="space-y-3.5 pt-3">
                                @foreach ($category['items'] as $itemIndex => $item)
                                    <div
                                        class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:border-slate-300 hover:shadow-xs transition-all duration-200">
                                        <!-- Nombre y Precio -->
                                        <div class="flex items-start justify-between gap-3 mb-2.5">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h3 class="font-bold text-slate-900 text-sm sm:text-base">
                                                        {{ $item['name'] }}
                                                    </h3>
                                                    @if (!empty($item['badge']))
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-md text-2xs font-semibold border {{ $item['badge_color'] }}">
                                                            {{ $item['badge'] }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Dónde comprarlo -->
                                                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                                                    <span class="text-rose-500">📍</span>
                                                    <span class="font-medium text-slate-700">Dónde comprar:</span>
                                                    <span
                                                        class="bg-white px-2 py-0.5 rounded border border-slate-200 text-slate-700 font-medium">
                                                        {{ $item['store'] }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Precio destacado -->
                                            <div class="shrink-0 text-right">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs sm:text-sm font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                                    {{ $item['price'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Campo de Nota personalizada -->
                                        <div class="mt-2.5 pt-2.5 border-t border-slate-200/60">
                                            <div
                                                class="flex items-start gap-2 rounded-lg bg-white p-2.5 border border-slate-200/70 shadow-2xs">
                                                <span class="text-slate-400 text-xs shrink-0 select-none">📝</span>
                                                <div class="w-full">
                                                    <label
                                                        class="block text-2xs font-bold uppercase tracking-wider text-slate-400 mb-0.5 select-none">
                                                        Nota / Detalles
                                                    </label>
                                                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                                                        {{ $item['note'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>