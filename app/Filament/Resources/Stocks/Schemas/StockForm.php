<?php

namespace App\Filament\Resources\Stocks\Schemas;

use App\Models\Produit;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('produit_id')
                ->label('Produit')
                ->disabledOn('edit')
                ->options(
                    Produit::pluck('nom', 'id')
                ),

            TextInput::make('quantite_en_stock')
                ->numeric()
                ->hiddenOn('edit')
                ->disabledOn('edit'),
            ]);
    }
}
