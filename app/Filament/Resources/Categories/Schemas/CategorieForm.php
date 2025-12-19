<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class CategorieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')
                ->label('Catégorie produit')
                ->required(),

            Textarea::make('description')
                ->label('Description'),
            ]);
    }
}
