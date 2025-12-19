<?php

namespace App\Models;

use App\Models\PakagingOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

     public function packaging(): HasMany
    {
        return $this->hasMany(Packaging::class);
    }
}


