<?php

namespace App\Filament\Resources\Commandes\Schemas;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\Stock;
use App\Models\Client;
use App\Models\Produit;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;

class CommandeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Détails de la commande')
                ->columnSpanFull()
                    ->schema([
                        Repeater::make('details')
                            ->orderable(false)
                            ->addActionLabel(__('Ajouter un produit à la commande'))
                            ->schema([
                                Grid::make(4)
                                    ->schema([

                                        Select::make('produit_id')
                                            ->label('Produit')
                                            ->allowHtml()
                                            ->native(false)
                                            ->searchable()
                                            ->live()
                                            ->preload()
                                            ->afterStateUpdated(function ($set, $get, $state) {
                                                if (! is_null($get('produit_id'))) {
                                                    $set('prix_unitaire', Produit::find($state)->prix_unitaire);
                                                } else {
                                                    $set('prix_unitaire', null);
                                                    $set('sous_total', null);
                                                    $set('quantite', null);
                                                }
                                            })
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->options(
                                                Produit::pluck('nom', 'id')
                                            ),
                                        //     ->getSearchResultsUsing(function (string $search) {
                                        //         $produits = Produit::where('nom', 'like', "%{$search}%")->limit(50)->get();

                                        //         return $produits->mapWithKeys(function ($produits) {
                                        //               return [$produits->getKey() => static::getCleanOptionString($produits)];
                                        //         })->toArray();
                                        //    })
                                        //    ->getOptionLabelUsing(function ($value): string {
                                        //        $produit = Produit::find($value);

                                        //        return static::getCleanOptionString($produit);
                                        //    })

                                        TextInput::make('prix_unitaire')
                                            ->suffix('FCFA')
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated(),

                                        TextInput::make('quantite')
                                            ->label('Quantité')
                                            ->numeric()
                                            ->debounce(500)
                                            ->live()
                                            ->minValue(1)
                                            ->maxValue(function ($get, $set) {

                                                if ($get('produit_id')) {

                                                    return Stock::where('produit_id', $get('produit_id'))->first()->quantite_en_stock;
                                                }

                                                return null;
                                            })
                                            ->afterStateUpdated(function ($get, $set) {

                                                $set('sous_total', intval($get('prix_unitaire')) * intval($get('quantite')));

                                            }),

                                        TextInput::make('sous_total')
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated(),
                                    ]),

                            ]),

                        Actions::make([
                            Action::make('Calculer total')
                                ->visible(fn ($get) => $get('details')[array_key_first($get('details'))]['produit_id'] ? true : false)

                                ->action(function (Get $get, Set $set) {

                                    $collection = collect($get('details'));

                                    $set('prixTotal', $collection->sum('sous_total'));

                                }),
                        ])->hiddenOn('view'),
                    ]),

                TextInput::make('prixTotal')
                    ->label('Prix total')
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                Select::make('client_id')
                    ->label('Client')
                    ->native(false)
                    ->searchable()
                    ->options(
                        Client::pluck('nom', 'id')
                    )
                    ->createOptionForm([

                        Grid::make(2)
                            ->schema([
                                TextInput::make('nom')
                                    ->required(),

                                TextInput::make('prenom')
                                    ->label('Prénom')
                                    ->required(),

                                TextInput::make('telephone')
                                    ->label('Téléphone')
                                    ->required(),

                                TextInput::make('adresse')
                                    ->required(),

                            ]),

                    ])
                    ->createOptionUsing(function (array $data): int {

                        return Client::create($data)->getKey();

                    })
                    ->getSearchResultsUsing(function (string $search): array {
                        return Client::query()
                            ->where(function (Builder $builder) use ($search) {
                                $searchString = "%$search%";
                                $builder->where('nom', 'like', $searchString)
                                    ->orWhere('prenom', 'like', $searchString)
                                    ->orWhere('telephone', 'like', $searchString);
                            })
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(function (Client $client) {
                                return [$client->id => $client->nom.' '.$client->prenom];
                            })
                            ->toArray();
                    }),

            ]);
    }
}
