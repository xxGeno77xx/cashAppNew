<?php

namespace App\Filament\Resources\Stocks\Tables;

use App\Models\Produit;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\StockVariation;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use App\Enums\StockVariationsEnums;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class StocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn(Builder $query) => $query->join('produits', 'produits.id', 'stocks.produit_id')
                    ->select('stocks.*', 'produits.nom as produit')
            )
            ->defaultSort('nom', 'asc')
            ->columns([
                TextColumn::make('produit')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('nom', 'like', "%{$search}%");
                    })
                    ->badge(),

                TextColumn::make('quantite_en_stock')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),

                Action::make('ravitailler')
                    ->action(fn($record, $data) => self::replenish(
                        $record,
                        $data['valeur_a_ajouter'],
                        StockVariationsEnums::Add()->value,
                    ))
                    ->icon('heroicon-o-plus')
                    ->color(Color::Green)
                    ->schema([

                        TextInput::make('valeur_a_ajouter')
                            ->label('Valeur à ajouter au stock')
                            ->numeric()
                             ->required()
                            ->minValue(1), 

                    ])
                    ->modalHeading(fn($record) => 'Approvisionner le stock de ' . Produit::find($record->produit_id)->nom)
                    ->after(function () {
                        Notification::make('ravitaillement')
                            ->title('Ravitaillement éffectué')
                            ->icon('heroicon-o-bell')
                            ->color(Color::Green)
                            ->send();
                    }),

                Action::make('desapprovisionner')
                    ->label('Désapprovisionner')
                    ->action(fn($record, $data) => self::replenish(
                        $record,
                        -$data['valeur_a_retirer'],
                        StockVariationsEnums::Sub()->value,
                    ))
                    ->icon('heroicon-o-minus')
                    ->color(Color::Red)
                    ->schema([

                        TextInput::make('valeur_a_retirer')
                            ->label('Valeur à retrancher au stock')
                            ->numeric()
                             ->required()
                            ->minValue(1)
                            ->maxValue(fn($record) => $record->quantite_en_stock - 1),

                    ])
                    ->modalHeading(fn($record) => 'Désapprovisionner le stock de ' . Produit::find($record->produit_id)->nom)
                    ->after(function () {
                        Notification::make('desapprovisionnement')
                            ->title('Désapprovisionnement éffectué')
                            ->icon('heroicon-o-bell')
                            ->color(Color::Red)
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function replenish($record, $variationValue, $type)
    {
        StockVariation::firstOrCreate([
            'stock_id' => $record->id,
            'current_stock_value' => $record->quantite_en_stock,
            'variation_stock_value' => $variationValue,
            'new_stock_value' => $variationValue + $record->quantite_en_stock,
            'type' => $type,
            'user_id' => Auth::user()->id,
        ]);

        $record->update(['quantite_en_stock' => $record->quantite_en_stock + $variationValue]);
    }
}
