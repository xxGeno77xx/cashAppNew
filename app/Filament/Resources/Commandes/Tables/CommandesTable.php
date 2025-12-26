<?php

namespace App\Filament\Resources\Commandes\Tables;

use App\Models\Client;
use App\Enums\RolesEnums;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;

class CommandesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(
            fn (Builder $query) => $query->leftjoin('clients', 'clients.id', 'commandes.client_id')
            ->select('commandes.*', 'clients.id as client'))


            ->columns([
                TextColumn::make('client')
                ->placeholder('-')
                ->formatStateUsing(function ($state) {

                    $client = Client::find($state);

                    return $client?->nom ?? 'Sans nom' .' '.$client?->prenom ?? 'Sans prénom';
                }),

            TextColumn::make('prixTotal')
                ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.').' FCFA')
              ->summarize(Sum::make()->label('Total')->formatStateUsing(fn($state) => number_format($state, 0 ,",", "."). " FCFA")),

            TextColumn::make('created_at')
                ->label('Date de la commande')
                ->date('D d M Y à H:i:s'),
            ])
            ->filters([
                Filter::make('created_at')
                    ->schema([

                        DatePicker::make('created_from')
                            ->label('Date début'),

                        DatePicker::make('created_until')
                            ->label('Date fin'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('commandes.created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('commandes.created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                EditAction::make()->visible(fn () => Auth::user()->hasAnyRole([RolesEnums::Administrateur()->value])),
              ViewAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
