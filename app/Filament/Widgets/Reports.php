<?php

namespace App\Filament\Widgets;

use App\Models\Produit;
use App\Models\Commande;
use App\Enums\RolesEnums;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use App\Static\PrintFunction;
use App\Models\StockVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Forms\Concerns\InteractsWithForms;

class Reports extends Widget implements HasSchemas
{
    protected string $view = 'filament.widgets.reports';

    use InteractsWithForms;

    public ?array $data = [];

    public static function getSort(): int
    {
        return 1; // static::$sort ?? -1;
    }

    public function getColumnSpan(): int|string|array
    {
        return 1;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function canView(): bool
    {

        return Auth::user()->hasAnyRole([
            RolesEnums::Administrateur()->value,
        ]);
    }

     public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Select::make('stat')
                    ->label('Etats globaux')
                    ->options([

                        1 => 'Ventes du jour',
                        2 => 'Vente sur période',
                        3 => 'Variations de stocks sur période',

                    ])
                    ->native(false)
                    ->live()
                    ->required(),

                Grid::make(2)
                    ->schema([
                        DatePicker::make('start')
                            ->label('Date début')
                            ->required(fn ($get) => in_array($get('stat'), [2,3]) ? true : false)
                            ->visible(fn ($get) => in_array($get('stat'), [2,3]) ? true : false),

                        DatePicker::make('end')
                            ->label('Date fin')
                            ->required(fn ($get) => in_array($get('stat'), [2,3]) ? true : false)
                            ->visible(fn ($get) => in_array($get('stat'), [2,3]) ? true : false),
                    ]),

            ])
            ->statePath('data');
    }

     public function generateStat()
    {
        $fileName = null;
        $viewName = null;
        $data = null;
        $start = $this->data['start'] ?? null;
        $end = $this->data['end'] ?? null;

        switch ($this->data['stat']) {
            case 1:

                $viewName = $fileName = 'filament.prints.todaySales';
                $data = self::getTodaySales();
                break;

            case 2:
                $viewName = 'filament.prints.globalSales';
                $fileName = 'ventes_totales';
                $data = self::getGlobalSales($start, $end);
                break;
            case 3:
                $viewName = 'filament.prints.stocksVariations';
                $fileName = 'Variatins_de_stocks';
                $data = self::getStockVariations($start, $end);

                break;
            default:
                null;

        }

        return PrintFunction::stream($viewName, ['data' => $data, 'start' => $start, 'end' => $end], $fileName);
    }

     public function getGlobalSales($start, $end)
    {

        $sales = $this->getSales()->whereBetween('commandes.created_at', [$start, $end])->get();

        $this->addProductNames($sales);

        return $sales;
    }

    public function getTodaySales()
    {

        $sales = $this->getSales()->whereDate('commandes.created_at', today())->get();

        $this->addProductNames($sales);

        return $sales;

    }

    public function getSales()
    {
        return $sales = Commande::leftJoin('clients', 'commandes.client_id', '=', 'clients.id')
            ->select([
                'commandes.id',
                'clients.id as client_id',
                'clients.nom',
                'clients.prenom',
                'clients.telephone',
                'commandes.details',
                DB::raw('SUM(commandes.prixTotal) as total_prix'),
                DB::raw('(SELECT SUM(prixTotal) FROM commandes) as total_general'),
            ])
            ->groupBy(
                'commandes.id',
                'clients.id',
                'clients.nom',
                'clients.prenom',
                'clients.telephone',
                'commandes.details'
            );

        return $sales;
    }

    public function addProductNames($sales)
    {
        // ⚙️ Précharger les noms des produits (plus performant)
        $produits = Produit::pluck('nom', 'id'); // [id => nom]

        // 🧩 Modifier directement "details"
        $sales->transform(function ($sale) use ($produits) {
            $details = is_array($sale->details)
                ? $sale->details
                : json_decode($sale->details, true);

            $sale->details = collect($details)->map(function ($item) use ($produits) {
                $item['nom_produit'] = $produits[$item['produit_id']] ?? 'Inconnu';

                return $item;
            })->values()->toArray();

            return $sale;
        });
    }

    public function getStockVariations($start, $end)
    {
        return StockVariation::join('stocks', 'stocks.id', 'stock_variations.stock_id')
        ->join('produits', 'produits.id', 'stocks.produit_id')
        ->join('users', 'users.id', 'user_id')
        ->whereBetween('stocks.created_at', [$start, $end])->get();
    }


}
