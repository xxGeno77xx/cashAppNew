<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Commande;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodaySales extends StatsOverviewWidget
{
     protected function getStats(): array
    {
         $ventesDuJour = Commande::whereDate("created_at", today())->get();

         $clients = Client::count();

         return [
            Stat::make('Ventes du jour',  $ventesDuJour->count())
            ->description('Total des ventes du jour: ' . number_format($ventesDuJour->sum("prixTotal"), 0, ",", ".") . " FCFA")
            ->color(Color::Green)
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([mt_rand(3,10), mt_rand(3,10), mt_rand(3,10), mt_rand(3,10),]),

            Stat::make('Clients', $clients),
        ];
    }
}
