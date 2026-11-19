<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GiftController extends Controller
{
    /**
     * Display the gift lists for the authenticated user.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $userLists = $user->giftLists()->latest()->get();

        $activeListId = $request->query('list', $request->session()->get('active_list_id'));
        $activeList = $userLists->firstWhere('id', (int) $activeListId) ?? $userLists->first();

        if ($activeList) {
            $request->session()->put('active_list_id', $activeList->id);
        }

        $categories = collect(Gift::CATEGORIES)->map(function ($meta, $key) use ($activeList) {
            $meta['items'] = $activeList
                ? $activeList->gifts()->where('category', $key)->latest()->get()
                : collect();

            return $meta;
        })->values()->all();

        return view('index', [
            'currentView' => 'gifts',
            'categories' => $categories,
            'userLists' => $userLists,
            'activeList' => $activeList,
        ]);
    }

    /**
     * Store a newly created gift in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gift_list_id' => ['required', 'integer'],
            'category' => ['required', 'string', Rule::in(array_keys(Gift::CATEGORIES))],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:100'],
            'store' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:100'],
            'note' => ['nullable', 'string'],
        ]);

        $list = $request->user()->giftLists()->findOrFail($validated['gift_list_id']);

        $list->gifts()->create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('home', ['list' => $list->id])
            ->with('status', '¡Artículo añadido con éxito a tu lista!');
    }

    /**
     * Update the specified gift in storage.
     */
    public function update(Request $request, Gift $gift): RedirectResponse
    {
        abort_if($gift->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'category' => ['required', 'string', Rule::in(array_keys(Gift::CATEGORIES))],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:100'],
            'store' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:100'],
            'note' => ['nullable', 'string'],
        ]);

        $gift->update($validated);

        return redirect()->route('home', ['list' => $gift->gift_list_id])
            ->with('status', '¡Artículo actualizado correctamente!');
    }

    /**
     * Remove the specified gift from storage.
     */
    public function destroy(Request $request, Gift $gift): RedirectResponse
    {
        abort_if($gift->user_id !== $request->user()->id, 403);

        $listId = $gift->gift_list_id;
        $gift->delete();

        return redirect()->route('home', ['list' => $listId])
            ->with('status', '¡Artículo eliminado de tu lista!');
    }
}
