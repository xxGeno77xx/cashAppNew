<?php

namespace App\Filament\Resources\Categories;

use BackedEnum;
use App\Enums\RolesEnums;
use App\Models\Categorie;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Categories\Pages\EditCategorie;
use App\Filament\Resources\Categories\Pages\ViewCategorie;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Pages\CreateCategorie;
use App\Filament\Resources\Categories\Schemas\CategorieForm;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Filament\Resources\Categories\Schemas\CategorieInfolist;

class CategorieResource extends Resource
{
    protected static ?string $model = Categorie::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::NumberedList;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CategorieForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CategorieInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategorie::route('/create'),
            'view' => ViewCategorie::route('/{record}'),
            'edit' => EditCategorie::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole([
            RolesEnums::Administrateur()->value,

        ]);
    }
}
