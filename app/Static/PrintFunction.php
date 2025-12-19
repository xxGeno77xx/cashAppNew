<?php

namespace App\Static;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;

class PrintFunction
{
    /**
     * Downloads file with given data
     */
    public static function stream(string $viewName, $data, string $fileName)
    {
 
        $pdf = Pdf::loadView($viewName, $data);

        return response()->streamDownload(function () use ($pdf) {

            echo $pdf->stream();

            Notification::make('stream')
                ->title(__('Téléchargement'))
                ->body(__('La fiche a été téléchargée'))
                ->icon('heroicon-o-printer')
                ->color('success')
                ->send();

        }, $fileName.'.pdf');

    }
}
