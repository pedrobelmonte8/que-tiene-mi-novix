<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'gift_list_id', 'category', 'name', 'price', 'store', 'badge', 'note'])]
class Gift extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'ropa' => [
            'id' => 'ropa',
            'icon' => '👗',
            'title' => 'Ropa y Calzado',
            'tag' => 'Moda & Accesorios',
            'tag_color' => 'bg-pink-100 text-pink-800 border-pink-200',
        ],
        'maquillaje' => [
            'id' => 'maquillaje',
            'icon' => '💄',
            'title' => 'Maquillaje & Belleza',
            'tag' => 'Beauty',
            'tag_color' => 'bg-rose-100 text-rose-800 border-rose-200',
        ],
        'cremas' => [
            'id' => 'cremas',
            'icon' => '🧴',
            'title' => 'Cremas & Skincare',
            'tag' => 'Cuidado Personal',
            'tag_color' => 'bg-teal-100 text-teal-800 border-teal-200',
        ],
        'comida' => [
            'id' => 'comida',
            'icon' => '🍣',
            'title' => 'Comida & Experiencias Gastro',
            'tag' => 'Gourmet',
            'tag_color' => 'bg-amber-100 text-amber-800 border-amber-200',
        ],
        'juguetes' => [
            'id' => 'juguetes',
            'icon' => '🎮',
            'title' => 'Juguetes, Juegos & Hobbies',
            'tag' => 'Entretenimiento',
            'tag_color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
        ],
        'otros' => [
            'id' => 'otros',
            'icon' => '🎁',
            'title' => 'Otros & Detalles Especiales',
            'tag' => 'Sorpresas',
            'tag_color' => 'bg-purple-100 text-purple-800 border-purple-200',
        ],
    ];

    /**
     * Get the user that owns the gift.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gift list that contains the gift.
     */
    public function giftList(): BelongsTo
    {
        return $this->belongsTo(GiftList::class);
    }
}
