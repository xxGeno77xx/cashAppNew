<?php

namespace App\Filament\Resources\Produits\Pages;

use App\Enums\RolesEnums;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Produits\ProduitResource;

class EditProduit extends EditRecord
{
    protected static string $resource = ProduitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

     protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()->hasRole([
            RolesEnums::Administrateur()->value,

        ]), 403);
    }
}

