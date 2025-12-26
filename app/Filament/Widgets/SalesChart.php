<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Commande;
use Flowframe\Trend\Trend;
use Filament\Schemas\Schema;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\DatePicker;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;

class SalesChart extends ChartWidget
{
    use HasFiltersSchema;

    protected ?string $heading = 'Statistiques des ventes';
    protected string $color = 'pink';
    protected bool $isCollapsible = true;
    public ?string $filter = 'today';

    protected function getData(): array
    {

         // Récupération des valeurs du formulaire via $this->filters
        $startDate = $this->filters['startDate'] ?? now()->startOfYear();
        $endDate = $this->filters['endDate'] ?? now();

        $data = Trend::model(Commande::class)
            ->between(
                start: Carbon::parse($startDate),
                end: Carbon::parse($endDate)->addDay(),
            )
            ->dateColumn('created_at')
            ->perMonth()
            ->count();

            $sums = Trend::model(Commande::class)
            ->between(
                start: Carbon::parse($startDate),
                end: Carbon::parse($endDate)->addDay(),
            )
            ->perMonth()
            ->sum('prixTotal');

        return [
            'datasets' => [
                [
                    'label' => 'Ventes effectuées',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],

                [
                    'label' => 'Montants des ventes',
                    'data' => $sums->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#eb36ebff',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            // Utilisation de Carbon pour le nom du mois en français
            'labels' => $data->map(fn(TrendValue $value) => 
                Carbon::parse($value->date)->translatedFormat('M Y')
            ),
            ];
       
    }

    protected function getType(): string
    {
        return 'bar';
    }

      public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('startDate')
                ->label('Date de début')
                ->default(now()->startOfYear()),
            DatePicker::make('endDate')
                ->label('Date de fin')
                ->afterOrEqual('startDate')
                ->default(now()),
        ]);
    }


}
