<?php

namespace App\Http\Controllers;

use App\Models\GiftList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GiftListController extends Controller
{
    /**
     * Store a newly created gift list in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:20'],
        ]);

        $giftList = $request->user()->giftLists()->create([
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?: '🎁',
        ]);

        return redirect()->route('home', ['list' => $giftList->id])
            ->with('status', "¡Lista «{$giftList->name}» creada correctamente!");
    }

    /**
     * Update the specified gift list in storage.
     */
    public function update(Request $request, GiftList $giftList): RedirectResponse
    {
        abort_if($giftList->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:20'],
        ]);

        $giftList->update([
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?: '🎁',
        ]);

        return redirect()->route('home', ['list' => $giftList->id])
            ->with('status', '¡Lista actualizada correctamente!');
    }

    /**
     * Remove the specified gift list from storage.
     */
    public function destroy(Request $request, GiftList $giftList): RedirectResponse
    {
        abort_if($giftList->user_id !== $request->user()->id, 403);

        $listName = $giftList->name;
        $giftList->delete();

        return redirect()->route('home')
            ->with('status', "Lista «{$listName}» eliminada.");
    }
}
