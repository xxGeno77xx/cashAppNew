<?php

namespace App\Filament\Resources\Produits\Tables;

use App\Models\Stock;
use Filament\Tables\Table;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Collection;

class ProduitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),

                TextColumn::make('nom')
                    ->label('catégorie de produit'),

                TextColumn::make('nom')
                    ->label('Nom du produit')
                    ->sortable()
                    ->searchable(isIndividual: true),

                TextColumn::make('description')
                    ->label('Description')
                    ->placeholder(new HtmlString('<i>Pas de descritption pour ce produit</i>'))
                    ->limit(25),

                TextColumn::make('prix_unitaire')
                    ->label('Prix unitaire (FCFA)'),

                // TextColumn::make('quantite')
                //     ->badge()
                //     ->label('Quantité en stock'),
            ])
            ->filters([
                SelectFilter::make('Catégorie')
                ->relationship('categorie', 'nom')
                ->searchable()
                ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([


                    BulkAction::make('CustomDeleteBulkAction')
                        ->label(__('Supprimer la sélection'))
                        ->icon('heroicon-o-trash')
                        ->color(Color::Red)
                        ->requiresConfirmation()
                        ->modalHeading(fn () => __('Etes vous sûr(e) de vouloir supprimer les éléments sélectionnés?'))
                        ->modalDescription(__('Cette suppression entraînera également celle des stocks des produits sélectionnés!'))
                        ->action(function (Collection $records) {

                            try {
                                foreach ($records as $record) {
                                    Stock::where('produit_id', $record->id)->get()->each->delete();

                                    $record->delete();
                                }

                                Notification::make('attention')
                                    ->body('Produits et stocks supprimés!!!')
                                    ->danger()
                                    ->icon('heroicon-o-trash')
                                    ->send();

                            } catch (\Exception $e) {
                                Notification::make('attention')
                                    ->body("Vous ne pouvez pas supprimer un produit pour lequel il existe un stock. Supprimez d'abord les stock des produits concernés!")
                                    ->danger()
                                    ->send();
                            }

                        }),

                ]),
            ]);
    }
}
