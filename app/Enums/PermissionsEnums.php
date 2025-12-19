<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self Categories_create()
 * @method static self Categories_read()
 * @method static self Categories_update()
 * @method static self Categories_delete()
 *                                         =======================================
 * @method static self Clients_create()
 * @method static self Clients_read()
 * @method static self Clients_update()
 * @method static self Clients_delete()
 *                                      =======================================
 * @method static self Commandes_create()
 * @method static self Commandes_read()
 * @method static self Commandes_update()
 * @method static self Commandes_delete()
 *                                        =======================================
 * @method static self Produits_create()
 * @method static self Produits_read()
 * @method static self Produits_update()
 * @method static self Produits_delete()
 *                                       =======================================
 * @method static self Stocks_create()
 * @method static self Stocks_read()
 * @method static self Stocks_update()
 * @method static self Stocks_delete()
 *                                     =======================================
 */
class PermissionsEnums extends Enum
{
    protected static function values()
    {
        return function (string $name): string|int {

            $traductions = [];

            return strtr(str_replace('_', ': ', str($name)), $traductions);
        };
    }
}
