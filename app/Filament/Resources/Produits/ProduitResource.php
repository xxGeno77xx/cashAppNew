<?php

namespace App\Filament\Resources\Produits;

use BackedEnum;
use App\Models\Produit;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Produits\Pages\EditProduit;
use App\Filament\Resources\Produits\Pages\ViewProduit;
use App\Filament\Resources\Produits\Pages\ListProduits;
use App\Filament\Resources\Produits\Pages\CreateProduit;
use App\Filament\Resources\Produits\Schemas\ProduitForm;
use App\Filament\Resources\Produits\Tables\ProduitsTable;

class ProduitResource extends Resource
{
    protected static ?string $model = Produit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ProduitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProduitsTable::configure($table);
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
            'index' => ListProduits::route('/'),
            'create' => CreateProduit::route('/create'),
            'edit' => EditProduit::route('/{record}/edit'),
            'view' => ViewProduit::route('/{record}'),
        ];
    }
}
