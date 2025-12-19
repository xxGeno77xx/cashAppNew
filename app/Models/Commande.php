<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'details' => 'array',
    ];

    //     public function getDetailsWithProduitsAttribute()
    // {
    //    $details = is_array($this->details) ? $this->details : json_decode($this->details, true);

    //     return collect($details)->map(function ($detail) {
    //         $produit = \App\Models\Produit::find($detail['produit_id']);
    //         $detail['nom_produit'] = $produit ? $produit->nom : 'Inconnu';
    //         return $detail;
    //     });
    // }

    // Ajoute automatiquement details_with_produits lors de la sérialisation (toArray / JSON)
    // protected $appends = ['details_with_produits'];

    // public function getDetailsWithProduitsAttribute()
    // {
    //     $details = is_array($this->details) ? $this->details : json_decode($this->details ?? '[]', true);
    //     if (empty($details)) {
    //         return [];
    //     }

    //     $produitIds = collect($details)->pluck('produit_id')->filter()->unique()->values()->all();
    //     $produits = \App\Models\Produit::whereIn('id', $produitIds)->get()->keyBy('id');

    //     return collect($details)->map(function ($detail) use ($produits) {
    //         // cast produit_id en int si nécessaire
    //         $pid = is_numeric($detail['produit_id']) ? (int) $detail['produit_id'] : $detail['produit_id'];
    //         $produit = $produits->get($pid);
    //         // adapte 'nom' si ton champ produit est 'name' ou autre
    //         $detail['nom_produit'] = $produit ? ($produit->nom ?? $produit->name ?? 'Inconnu') : 'Inconnu';
    //         return $detail;
    //     })->select([
    //                 'nom_produit'
    //             ])->all();

    // }

    // public function produits()
    // {
    //     return $this->belongsToMany(Produit::class, 'commande_produits')
    //         ->withPivot(['quantite', 'prix_unitaire']);
    // }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
