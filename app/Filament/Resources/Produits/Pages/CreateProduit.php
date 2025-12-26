<?php

namespace App\Filament\Resources\Produits\Pages;

use App\Enums\RolesEnums;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Produits\ProduitResource;

class CreateProduit extends CreateRecord
{
    protected static string $resource = ProduitResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->hasRole([
            RolesEnums::Administrateur()->value,

        ]), 403);
    }
}
