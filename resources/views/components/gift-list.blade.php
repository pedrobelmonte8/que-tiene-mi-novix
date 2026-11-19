@props(['categories' => null, 'userLists' => null, 'activeList' => null])

@php
    // Si no se pasan categorías, usamos las predeterminadas del modelo Gift
    $categories = $categories ?? collect(\App\Models\Gift::CATEGORIES)->map(function ($meta) {
        $meta['items'] = collect();
        return $meta;
    })->values()->all();

    $userLists = $userLists ?? collect();
    $activeList = $activeList ?? null;
@endphp

<div>
    <!-- Encabezado de la lista -->
    <header class="text-center mb-8">
        <span
            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-400 mb-3 shadow-xs border border-rose-200 dark:border-rose-700/60">
            🎁 Mi Lista de Regalos Personal
        </span>

        {{-- Título con selector de lista incrustado --}}
        <div class="relative mb-2">
            <div class="inline-flex items-center justify-center gap-2 flex-wrap">
                <button
                    type="button"
                    onclick="toggleListDropdown()"
                    title="Cambiar lista activa"
                    class="inline-flex items-center gap-2 group cursor-pointer select-none focus:outline-hidden"
                >
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 dark:text-slate-50 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors flex items-center gap-2">
                        <span class="text-3xl sm:text-4xl select-none">{{ $activeList?->icon ?? '🎁' }}</span>
                        <span>¿Qué regalar a</span>
                        <span class="text-rose-600 dark:text-rose-400 underline decoration-dotted underline-offset-4">
                            {{ $activeList?->name ?? 'mi novix' }}
                        </span>
                        <span>?</span>
                    </h1>
                    <span class="flex items-center justify-center w-7 h-7 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 group-hover:bg-rose-100 dark:group-hover:bg-rose-900/40 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-all text-xs font-bold">
                        ▼
                    </span>
                </button>

                @if ($activeList)
                    {{-- Botón editar nombre de la lista activa --}}
                    <button
                        type="button"
                        onclick="openEditListModal({{ $activeList->id }}, '{{ addslashes($activeList->name) }}', '{{ $activeList->icon ?? '🎁' }}')"
                        title="Modificar lista"
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer select-none"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                @endif
            </div>

            {{-- Desplegable de listas --}}
            <div
                id="list-dropdown"
                class="hidden absolute left-1/2 -translate-x-1/2 mt-2 w-80 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/80 shadow-2xl z-50 p-2.5 text-left"
            >
                <div class="flex items-center justify-between px-3 py-1.5 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-2xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 select-none">
                        Tus listas de regalos
                    </span>
                    <span class="text-2xs font-semibold text-slate-400">
                        {{ $userLists->count() }} {{ $userLists->count() === 1 ? 'lista' : 'listas' }}
                    </span>
                </div>

                <div class="max-h-60 overflow-y-auto space-y-1 py-1.5">
                    @forelse ($userLists as $list)
                        <div class="flex items-center gap-1 group/li rounded-xl p-1 transition-colors {{ $activeList?->id === $list->id ? 'bg-rose-50/70 dark:bg-rose-900/25' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60' }}">
                            <a
                                href="{{ route('home', ['list' => $list->id]) }}"
                                onclick="document.getElementById('list-dropdown').classList.add('hidden')"
                                class="flex-1 flex items-center gap-2 px-2 py-1.5 rounded-lg text-sm font-semibold truncate transition-colors {{ $activeList?->id === $list->id ? 'text-rose-700 dark:text-rose-400' : 'text-slate-700 dark:text-slate-300' }}"
                            >
                                <span class="text-base select-none">{{ $list->icon ?? '🎁' }}</span>
                                <span class="truncate">{{ $list->name }}</span>
                                @if ($activeList?->id === $list->id)
                                    <span class="ml-auto text-rose-600 dark:text-rose-400 text-xs">✓</span>
                                @endif
                            </a>

                            {{-- Botón editar nombre de la lista --}}
                            <button
                                type="button"
                                title="Cambiar nombre e icono"
                                onclick="openEditListModal({{ $list->id }}, '{{ addslashes($list->name) }}', '{{ $list->icon ?? '🎁' }}')"
                                class="p-1.5 rounded-lg text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-200/60 dark:hover:bg-slate-700 transition-colors cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            {{-- Botón eliminar lista (solo si hay más de una) --}}
                            @if ($userLists->count() > 1)
                                <form
                                    action="{{ route('gift-lists.destroy', $list) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro/a que deseas eliminar la lista «{{ addslashes($list->name) }}» y todos sus artículos? Esta acción no se puede deshacer.');"
                                    class="inline shrink-0"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        title="Eliminar lista"
                                        class="p-1.5 rounded-lg text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-colors cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="px-3 py-2 text-xs text-slate-400 dark:text-slate-500 italic">No tienes listas aún.</p>
                    @endforelse
                </div>

                {{-- Crear nueva lista --}}
                <div class="mt-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <form
                        action="{{ route('gift-lists.store') }}"
                        method="POST"
                        class="space-y-1.5 px-1"
                        onsubmit="return validateNewListName(this)"
                    >
                        @csrf
                        <label for="new-list-name" class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            + Crear nueva lista
                        </label>
                        <div class="flex gap-1.5">
                            <input
                                id="new-list-name"
                                type="text"
                                name="name"
                                required
                                placeholder="Nombre de la lista..."
                                maxlength="100"
                                class="flex-1 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 transition-all"
                            >
                            <button
                                type="submit"
                                class="px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-xs transition-all cursor-pointer active:scale-95 shrink-0"
                            >
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base max-w-lg mx-auto">
            Tus ideas organizadas por categoría. Abre cualquier tarjeta para añadir, modificar o eliminar artículos.
        </p>

        @if ($userLists->isEmpty())
            <div class="mt-4 p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700/60 text-sm text-rose-700 dark:text-rose-400 font-medium">
                Aún no tienes ninguna lista activa. Haz clic en el botón superior para crear una.
            </div>
        @endif
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

    <!-- Modal para Modificar Nombre e Icono de la Lista -->
    <div
        id="edit-list-modal"
        class="fixed inset-0 z-100 hidden items-center justify-center p-4 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity duration-200"
        role="dialog"
        aria-modal="true"
    >
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-slate-900 p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 flex items-center gap-2">
                    <span id="edit-list-icon-preview" class="text-xl">🎁</span>
                    <span>Modificar lista</span>
                </h3>
                <button
                    type="button"
                    onclick="closeEditListModal()"
                    class="p-1 rounded-full text-slate-400 hover:text-slate-600 dark:hover:text-slate-300"
                >
                    ✕
                </button>
            </div>
            <form id="edit-list-form" method="POST" action="" class="space-y-4 pt-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit-list-name-input" class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">
                        Nombre de la lista
                    </label>
                    <input
                        type="text"
                        id="edit-list-name-input"
                        name="name"
                        required
                        maxlength="100"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-rose-400 transition-all font-medium"
                    >
                </div>

                {{-- Selector de Icono --}}
                <div>
                    <label class="block text-2xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                        Icono de la lista
                    </label>
                    <input type="hidden" name="icon" id="edit-list-icon-input" value="🎁">
                    <div class="grid grid-cols-6 sm:grid-cols-8 gap-2 p-2 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60">
                        @php
                            $availableIcons = ['🎁', '💖', '💍', '✨', '🎂', '🎄', '🎉', '🌟', '🧸', '👗', '🎮', '🍫', '📚', '🚀', '🌺', '🍷'];
                        @endphp
                        @foreach ($availableIcons as $iconOpt)
                            <button
                                type="button"
                                onclick="selectEditListIcon('{{ $iconOpt }}')"
                                data-edit-icon="{{ $iconOpt }}"
                                class="flex items-center justify-center h-10 rounded-xl text-xl hover:scale-110 hover:bg-white dark:hover:bg-slate-700 border border-transparent transition-all cursor-pointer select-none"
                            >
                                {{ $iconOpt }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button
                        type="button"
                        onclick="closeEditListModal()"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-bold shadow-xs active:scale-95 transition-all"
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Componente Modal para Crear y Modificar Artículos -->
    <x-gift-modal :activeList="$activeList" />
</div>

<script>
    function toggleListDropdown() {
        const dd = document.getElementById('list-dropdown');
        if (dd) {
            dd.classList.toggle('hidden');
        }
    }

    function validateNewListName(form) {
        const input = form.querySelector('#new-list-name');
        if (!input || !input.value.trim()) {
            input?.focus();
            return false;
        }
        return true;
    }

    function selectEditListIcon(icon) {
        const iconInput = document.getElementById('edit-list-icon-input');
        const iconPreview = document.getElementById('edit-list-icon-preview');
        if (iconInput) iconInput.value = icon;
        if (iconPreview) iconPreview.textContent = icon;

        document.querySelectorAll('[data-edit-icon]').forEach(btn => {
            if (btn.getAttribute('data-edit-icon') === icon) {
                btn.classList.add('bg-white', 'dark:bg-slate-700', 'border-rose-400', 'shadow-xs');
            } else {
                btn.classList.remove('bg-white', 'dark:bg-slate-700', 'border-rose-400', 'shadow-xs');
            }
        });
    }

    function openEditListModal(listId, currentName, currentIcon = '🎁') {
        const modal = document.getElementById('edit-list-modal');
        const form = document.getElementById('edit-list-form');
        const input = document.getElementById('edit-list-name-input');
        if (!modal || !form || !input) return;

        form.action = `/gift-lists/${listId}`;
        input.value = currentName;

        selectEditListIcon(currentIcon || '🎁');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        input.focus();
    }

    function closeEditListModal() {
        const modal = document.getElementById('edit-list-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', (e) => {
        const dd = document.getElementById('list-dropdown');
        if (!dd || dd.classList.contains('hidden')) return;

        const isTrigger = e.target.closest('[onclick*="toggleListDropdown"]') || e.target.closest('#list-dropdown');
        if (!isTrigger) {
            dd.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEditListModal();
            document.getElementById('list-dropdown')?.classList.add('hidden');
        }
    });
</script>