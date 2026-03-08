<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            'role_show',
            'role_create',
            'role_update',
            'role_delete',

            'user_show',
            'user_create',
            'user_update',
            'user_delete',

            'auth_data_show',

            'settings_update',

        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[] = Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $admin->syncPermissions($createdPermissions);

    }
}
