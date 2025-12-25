<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceitController;


Route::get('/recu/{commande}', ReceitController::class)->name('recu');

Route::get('/test', function () {
    return view('welcome');
});
