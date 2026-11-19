<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'name', 'icon'])]
class GiftList extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the gift list.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gifts that belong to this list.
     */
    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }
}
