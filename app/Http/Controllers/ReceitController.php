<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReceitController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Commande $commande)
    {
        $commande->update(['editable' => false]);

        // return Pdf::loadView('receitView', ['commande' => $commande])
        //     ->stream('Recu_numero_'.$commande.'.pdf');

        return Pdf::loadView('filament.prints.ticket', [
            'commande' => $commande,
            'ticket' => null,
            'userName' => Auth::user()->name ,
            ])
            ->stream('Recu_numero_'.$commande.'.pdf');

    }
}
