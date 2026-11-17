@props(['categories' => null])

@php
    // Si no se pasan categorías, usamos las predeterminadas del modelo Gift
    $categories = $categories ?? collect(\App\Models\Gift::CATEGORIES)->map(function ($meta) {
        $meta['items'] = collect();
        return $meta;
    })->values()->all();
@endphp

<div>
    <!-- Encabezado de la lista -->
    <header class="text-center mb-8">
            <span
                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-400 mb-3 shadow-xs border border-rose-200 dark:border-rose-700/60">
                🎁 Mi Lista de Regalos Personal
            </span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 dark:text-slate-50 mb-2">
                    ¿Qué regalar a mi novix?
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base max-w-lg mx-auto">
                    Tus ideas organizadas por categoría. Abre cualquier tarjeta para añadir, modificar o eliminar
                    artículos.
                </p>
    </header>

    <!-- Contenedor de cards apiladas en cascada (la última está más adelante) -->
    <div class="relative flex flex-col pt-2 pb-10" id="gift-accordion">
        @foreach ($categories as $index => $category)
            @php
                $isOpen = $loop->first;
                $zIndex = ($index + 1) * 10;
                $items = $category['items'] ?? [];
                $itemsCount = count($items);
            @endphp

            <article data-accordion-item data-open="{{ $isOpen ? 'true' : 'false' }}" style="z-index: {{ $zIndex }};"
                class="relative group rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-700/70 shadow-[0_-3px_10px_rgba(0,0,0,0.04),0_6px_14px_rgba(0,0,0,0.06)] dark:shadow-[0_-3px_10px_rgba(0,0,0,0.2),0_6px_14px_rgba(0,0,0,0.3)] transition-all duration-300 first:mt-0 -mt-4 sm:-mt-5 hover:-translate-y-1 hover:border-slate-300 dark:hover:border-slate-600 data-[open=true]:translate-y-0 data-[open=true]:border-rose-400 dark:data-[open=true]:border-rose-500 data-[open=true]:ring-4 data-[open=true]:ring-rose-100/70 dark:data-[open=true]:ring-rose-900/40 data-[open=true]:shadow-xl">
                <!-- Cabecera / Categoría (siempre visible) -->
                <button type="button" data-accordion-trigger aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left cursor-pointer select-none focus:outline-hidden">
                    <div class="flex items-center gap-3.5 min-w-0 pr-3">
                            <span
                                class="shrink-0 flex items-center justify-center w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 text-2xl group-hover:scale-105 group-data-[open=true]:bg-rose-100 dark:group-data-[open=true]:bg-rose-900/40 transition-all duration-300 shadow-xs">
                                {{ $category['icon'] }}
                            </span>
                            <div class="truncate">
                                <div class="flex items-center gap-2">
                                        <h2
                                            class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 group-data-[open=true]:text-rose-600 dark:group-data-[open=true]:text-rose-400 transition-colors duration-200 truncate">
                                            {{ $category['title'] }}
                                        </h2>
                                        <span
                                            class="hidden sm:inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold {{ $category['tag_color'] }}">
                                            {{ $category['tag'] }}
                                        </span>
                                </div>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                                    {{ $itemsCount }} {{ $itemsCount === 1 ? 'artículo guardado' : 'artículos guardados' }}
                                </p>
                            </div>
                    </div>

                    <!-- Badge con contador y flecha giratoria -->
                    <div class="shrink-0 flex items-center gap-2.5">
                            <span
                                class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 group-data-[open=true]:bg-rose-100 dark:group-data-[open=true]:bg-rose-900/40 group-data-[open=true]:text-rose-700 dark:group-data-[open=true]:text-rose-400 transition-colors">
                                {{ $itemsCount }} ideas
                            </span>
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300 group-data-[open=true]:text-rose-500 dark:group-data-[open=true]:text-rose-400 group-data-[open=true]:rotate-180 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                </button>

                <!-- Lista de Artículos desplegable -->
                <div
                    class="grid transition-all duration-300 ease-in-out group-data-[open=true]:grid-rows-[1fr] group-data-[open=false]:grid-rows-[0fr]">
                    <div class="overflow-hidden">
                            <div
                                class="p-4 sm:p-6 pt-0 pb-7 sm:pb-8 border-t border-slate-100 dark:border-slate-800 space-y-4">
                                <!-- Barra de acción superior de la categoría -->
                                        <div
                                            class="flex items-center justify-between pt-3 pb-1 border-b border-slate-100/80 dark:border-slate-800/80">
                                            <span
                                                class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                                Artículos en esta lista
                                            </span>
                                            <button type="button"
                                                onclick="openCreateGiftModal('{{ $category['id'] }}', '{{ $category['title'] }}', '{{ $category['icon'] }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs bg-rose-600 hover:bg-rose-700 text-white shadow-xs shadow-rose-600/20 active:scale-95 transition-all cursor-pointer select-none">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span>Añadir artículo</span>
                                            </button>
                                        </div>

                                        <!-- Listado de Artículos -->
                                        @if ($itemsCount > 0)
                                            <div class="space-y-3 pt-1">
                                                @foreach ($items as $item)
                                                    @php
                                                        $itemArray = is_array($item) ? $item : $item->toArray();
                                                        $itemId = $itemArray['id'] ?? null;
                                                        $itemName = $itemArray['name'] ?? '';
                                                        $itemPrice = $itemArray['price'] ?? '';
                                                        $itemStore = $itemArray['store'] ?? '';
                                                        $itemBadge = $itemArray['badge'] ?? '';
                                                        $itemNote = $itemArray['note'] ?? '';
                                                    @endphp

                                                        <div
                                                            class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 hover:bg-white dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 hover:shadow-xs transition-all duration-200 group/item">
                                                            <!-- Fila Superior: Nombre, Badge y Acciones -->
                                                            <div class="flex items-start justify-between gap-3 mb-2">
                                                                <div class="flex-1 min-w-0">
                                                                    <div class="flex items-center gap-2 flex-wrap">
                                                                            <h3
                                                                                class="font-bold text-slate-900 dark:text-slate-100 text-sm sm:text-base">
                                                                                {{ $itemName }}
                                                                            </h3>
                                                                            @if (!empty($itemBadge))
                                                                                    <span
                                                                                        class="inline-flex items-center px-2 py-0.5 rounded-md text-2xs font-semibold bg-rose-50 dark:bg-rose-900/40 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-700/60">
                                                                                        {{ $itemBadge }}
                                                                                    </span>
                                                                            @endif
                                                                    </div>

                                                                    <!-- Dónde Comprarlo -->
                                                                    @if (!empty($itemStore))
                                                                                <div
                                                                                    class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                                                    <span
                                                                                        class="text-rose-500 dark:text-rose-400">📍</span>
                                                                                    <span
                                                                                        class="font-medium text-slate-700 dark:text-slate-300">Dónde
                                                                                        comprar:</span>
                                                                                    <span
                                                                                        class="bg-white dark:bg-slate-700 px-2 py-0.5 rounded border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium">
                                                                                        {{ $itemStore }}
                                                                                    </span>
                                                                                </div>
                                                                    @endif
                                                                    </div>

                                                                    <!-- Precio y Acciones (Editar y Eliminar) -->
                                                                    <div class="shrink-0 flex items-center gap-2">
                                                                        @if (!empty($itemPrice))
                                                                                <span
                                                                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs sm:text-sm font-extrabold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-700/60 shadow-2xs">
                                                                                    {{ $itemPrice }}
                                                                                </span>
                                                                        @endif

                                                                            @if ($itemId)
                                                                                <!-- Botón Modificar / Editar -->
                                                                                <button type="button" title="Modificar artículo"
                                                                                    onclick='openEditGiftModal(@json($itemArray))'
                                                                                    class="p-1.5 rounded-lg text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-200/70 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                                        stroke="currentColor">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                                    </svg>
                                                                                </button>

                                                                                <!-- Botón Eliminar -->
                                                                                <form action="{{ route('gifts.destroy', $itemId) }}"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('¿Seguro/a que deseas eliminar «{{ addslashes($itemName) }}» de tu lista?');"
                                                                                    class="inline">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" title="Eliminar artículo"
                                                                                        class="p-1.5 rounded-lg text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-colors cursor-pointer">
                                                                                        <svg class="w-4 h-4" fill="none"
                                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                                            <path stroke-linecap="round"
                                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </form>
                                                                            @endif
                                                                    </div>
                                                                </div>

                                                                <!-- Nota / Detalles -->
                                                                @if (!empty($itemNote))
                                                                            <div
                                                                                class="mt-2.5 pt-2.5 border-t border-slate-200/60 dark:border-slate-700/60">
                                                                                <div
                                                                                    class="flex items-start gap-2 rounded-lg bg-white dark:bg-slate-900 p-2.5 border border-slate-200/70 dark:border-slate-700/60 shadow-2xs">
                                                                                    <span
                                                                                        class="text-slate-400 dark:text-slate-500 text-xs shrink-0 select-none">📝</span>
                                                                                    <div class="w-full">
                                                                                            <label
                                                                                                class="block text-2xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-0.5 select-none">
                                                                                                Nota / Detalles
                                                                                            </label>
                                                                                            <p
                                                                                                class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-normal">
                                                                                                {{ $itemNote }}
                                                                                            </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                @endif
                                                                    </div>
                                                @endforeach
                                                            </div>
                                        @else
                                                            <!-- Estado vacío si la categoría no tiene artículos -->
                                                                <div
                                                                    class="text-center py-7 px-4 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/30">
                                                                    <span class="text-3xl block mb-2 select-none">✨</span>
                                                                    <p
                                                                        class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                                                        Aún no tienes regalos en {{ $category['title'] }}
                                                                    </p>
                                                                    <p
                                                                        class="text-2xs sm:text-xs text-slate-400 dark:text-slate-500 mb-3 max-w-xs mx-auto">
                                                                        Guarda ideas que mencione en conversaciones, tallas o
                                                                        cosas que le gusten.
                                                                    </p>
                                                                    <button type="button"
                                                                        onclick="openCreateGiftModal('{{ $category['id'] }}', '{{ $category['title'] }}', '{{ $category['icon'] }}')"
                                                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl font-bold text-xs bg-rose-600 hover:bg-rose-700 text-white shadow-xs shadow-rose-600/20 active:scale-95 transition-all cursor-pointer select-none">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                                        </svg>
                                                                        <span>Añadir el primer artículo</span>
                                                                    </button>
                                                                </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
            </article>
        @endforeach
    </div>

    <!-- Componente Modal para Crear y Modificar Artículos -->
    <x-gift-modal />
</div>