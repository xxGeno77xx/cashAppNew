<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')->label('Nom')->required(),
                TextInput::make('prenom')->label('Prenom')->required(),
                TextInput::make('telephone')->label('Téléphone')->required(),
                TextInput::make('adresse')->label('Adresse')->required(),
            ]);
    }
}
