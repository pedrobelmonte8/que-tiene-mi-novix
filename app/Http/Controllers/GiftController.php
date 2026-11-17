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
        $userGifts = $request->user()->gifts()->latest()->get()->groupBy('category');

        $categories = collect(Gift::CATEGORIES)->map(function ($meta, $key) use ($userGifts) {
            $meta['items'] = $userGifts->get($key, collect());

            return $meta;
        })->values()->all();

        return view('index', [
            'currentView' => 'gifts',
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created gift in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', Rule::in(array_keys(Gift::CATEGORIES))],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:100'],
            'store' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:100'],
            'note' => ['nullable', 'string'],
        ]);

        $request->user()->gifts()->create($validated);

        return back()->with('status', '¡Artículo añadido con éxito a tu lista!');
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

        return back()->with('status', '¡Artículo actualizado correctamente!');
    }

    /**
     * Remove the specified gift from storage.
     */
    public function destroy(Request $request, Gift $gift): RedirectResponse
    {
        abort_if($gift->user_id !== $request->user()->id, 403);

        $gift->delete();

        return back()->with('status', '¡Artículo eliminado de tu lista!');
    }
}

