<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnums;
use App\Enums\RolesEnums;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = PermissionsEnums::toValues();

        foreach ($permissions as $key => $permission) {
            Permission::firstOrCreate([
                'name' => $permission,

            ]);
        }

        $roles = RolesEnums::toValues();

        foreach ($roles as $key => $role) {
            Role::firstOrCreate([
                'name' => $role,
            ]);
        }

        $adminUser = User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'userName' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $caissierPermissions = [
            PermissionsEnums::Categories_create()->value,
            PermissionsEnums::Categories_read()->value,
            PermissionsEnums::Categories_update()->value,

            PermissionsEnums::Clients_create()->value,
            PermissionsEnums::Clients_read()->value,
            PermissionsEnums::Clients_update()->value,

            PermissionsEnums::Commandes_create()->value,
            PermissionsEnums::Commandes_read()->value,

            PermissionsEnums::Produits_create()->value,
            PermissionsEnums::Produits_read()->value,

            PermissionsEnums::Stocks_read()->value,
        ];

        $adminRole = Role::where('name', RolesEnums::Administrateur()->value)->first();

        $adminRole->syncPermissions($permissions);

        $adminUser->syncRoles($adminRole);

        $caissierRole = Role::where('name', RolesEnums::Caissier()->value)->first();

        $caissierRole->syncPermissions($caissierPermissions);

    }
}
