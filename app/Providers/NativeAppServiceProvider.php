<?php

namespace App\Providers;

use App\Models\User;
use Native\Desktop\Facades\Menu;
use Native\Desktop\Facades\Window;
use Native\Desktop\Facades\MenuBar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Native\Desktop\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {



        // if (app()->runningInConsole()) {
        //     return;
        // }

        // if (Schema::hasTable('users') && ! User::exists()) {
        //     Artisan::call('db:seed', [
        //         '--force' => true,
        //     ]);
        // }

        Menu::create(
            Menu::file(),
            Menu::edit(),
            Menu::view(),
            Menu::window(),
            Menu::make(
                Menu::route('filament.admin.pages.dashboard', 'Retour à l\'accueil'), 
            )->label('Navigation')

        );

        Window::open()->title('Shopify')->showDevTools(false)->maximized();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [];
    }
}
