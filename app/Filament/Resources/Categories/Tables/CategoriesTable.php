<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Stock;
use App\Models\Produit;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Collection;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Actions\BulkAction;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                ->label('catégorie de produit'),

            TextColumn::make('description')
                ->label('Description'),

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

                    BulkAction::make('CustomDeleteBulkAction')
                        ->label('Supprimer la sélection')
                        ->icon('heroicon-o-trash')
                        ->color(Color::Red)
                        ->requiresConfirmation()
                        ->modalHeading(fn () => __('Etes vous sûr(e) de vouloir supprimer les éléments sélectionnés?'))
                        ->modalDescription(__('Cette suppression entraînera également celle des stocks des produits sélectionnés!'))
                        ->action(function (Collection $records) {

                            try {
                                foreach ($records as $record) {
                                    $products = Produit::where('categorie_id', $record->id)->get();

                                    $stocks = Stock::whereIn('produit_id', $products->pluck('id'))->get();

                                    $stocks->each->delete();

                                    $products->each->delete();

                                    $record->delete();
                                }

                                Notification::make('attention')
                                    ->body('Catégories, produits et stocks supprimés!!!')
                                    ->danger()
                                    ->icon('heroicon-o-trash')
                                    ->send();

                            } catch (\Exception $e) {

                                Notification::make('attention')
                                    ->body("Vous ne pouvez pas supprimer une catégorie qui comporte des produits. Supprimez d'abord les produits concernés!")
                                    ->danger()
                                    ->send();
                            }

                        }),
                ]),
            ]);
    }
}
