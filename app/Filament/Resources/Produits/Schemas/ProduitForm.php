<?php

namespace App\Filament\Resources\Produits\Schemas;

use App\Models\Categorie;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class ProduitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Produit')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('nom')
                                    ->label('Nom du produit')
                                    ->unique(ignoreRecord: true)
                                    ->required(),

                                TextInput::make('prix_unitaire')
                                    ->label('Prix unitaire (FCFA)')
                                    ->suffix('FCFA')
                                    ->numeric()
                                    ->required(),

                                Select::make('categorie_id')
                                    ->required()
                                    ->searchable()
                                    ->options(
                                        Categorie::pluck('nom', 'id')
                                    )
                                    ->label('Catégorie')
                                    ->createOptionForm([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('nom')->label('Catégorie produit'),
                                                Textarea::make('Description')->label('Description'),
                                            ]),
                                    ])
                                    ->createOptionUsing(function (array $data): int {

                                        return Categorie::create($data)->getKey();
                                    }),

 
                                        Textarea::make('description')
                                            ->label('Description')
                                            ->placeholder('-'),

                                        FileUpload::make('image')
                                            ->image()
                                            ->maxSize(2048),


                            ]),

                            Section::make()
                    ->schema([
                        Repeater::make('test')
                            ->maxItems(1)
                            ->defaultItems(1)
                            ->deletable(false)
                            ->addable(false)
                            ->relationship('stock')
                            ->schema([

                                TextInput::make('quantite_en_stock')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->disabledOn('edit'),

                            ]),
                    ]),

                    ])->columnSpanFull(),


            ]);
    }
}
