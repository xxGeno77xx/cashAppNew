<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function stockVariations(): HasMany
    {
        return $this->hasMany(StockVariation::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
