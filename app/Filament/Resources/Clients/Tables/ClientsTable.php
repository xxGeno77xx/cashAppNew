<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                ->label('Nom du client')
                ->searchable(),
            TextColumn::make('prenom')
                ->label('Prénom du client')
                ->searchable(),
            TextColumn::make('telephone')
                ->label('Téléphone')
                ->searchable(),
            TextColumn::make('adresse')
                ->label('Adresse')
                ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
