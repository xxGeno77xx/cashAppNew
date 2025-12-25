<?php

namespace App\Filament\Resources\Stocks\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Support\Colors\Color;
use App\Enums\StockVariationsEnums;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Actions\DissociateBulkAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;

class StockVariationsRelationManager extends RelationManager
{
    protected static string $relationship = 'stockVariations';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
              
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('id'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                   TextColumn::make('current_stock_value')
                    ->label('Quantié en stock avant'),

                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state == StockVariationsEnums::Add()->value ? 'Approvisionnement' : 'Désapprovisonnement')
                    ->badge()
                    ->color(fn ($state) => $state == StockVariationsEnums::Add()->value ? Color::Green : Color::Red),

                 TextColumn::make('new_stock_value')
                    ->label('Quantié en stock après'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
                // DissociateAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
