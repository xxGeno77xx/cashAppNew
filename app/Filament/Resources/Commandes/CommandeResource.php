<?php

namespace App\Filament\Resources\Commandes;

use BackedEnum;
use App\Models\Commande;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Commandes\Pages\EditCommande;
use App\Filament\Resources\Commandes\Pages\ViewCommande;
use App\Filament\Resources\Commandes\Pages\ListCommandes;
use App\Filament\Resources\Commandes\Pages\CreateCommande;
use App\Filament\Resources\Commandes\Schemas\CommandeForm;
use App\Filament\Resources\Commandes\Tables\CommandesTable;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $recordTitleAttribute = 'namename';

    public static function form(Schema $schema): Schema
    {
        return CommandeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommandesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommandes::route('/'),
            'create' => CreateCommande::route('/create'),
            'edit' => EditCommande::route('/{record}/edit'),
            'view' => ViewCommande::route('/{record}/view'),
        ];
    }
}
