<?php

namespace App\Filament\Resources\Commandes\Pages;

use App\Models\Commande;
use App\Enums\RolesEnums;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Commandes\CommandeResource;

class ViewCommande extends ViewRecord
{
    protected static string $resource = CommandeResource::class;

    protected function getHeaderActions(): array
    {
        return [
         DeleteAction::make()
                ->visible(fn () => auth()->user()->hasRole(RolesEnums::Administrateur()->value)),

           EditAction::make()
                ->visible(function (Model $record) {

                    if ($record->editable == 1) {

                        if (auth()->user()->hasRole(RolesEnums::Administrateur()->value)) {
                            return true;
                        }

                        return false;
                    } else {
                        return true;
                    }

                }),

            Action::make('imprimer')
                ->color('success')
                ->label('Imprimer le reçu')
                ->url(fn (Commande $record) => route('recu', [
                    'commande' => $record,
                    ]))
                ->openUrlInNewTab(),
        ];

    }
}
