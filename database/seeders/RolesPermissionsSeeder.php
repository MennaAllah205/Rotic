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

            'client_show',
            'client_create',
            'client_update',
            'client_delete',

            'projects_show',
            'projects_create',
            'projects_update',
            'projects_delete',

        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            // Create permission for web guard
            $createdPermissions[] = Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
            // Create permission for sanctum guard
            $createdPermissions[] = Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'sanctum']
            );
        }

        $owner = Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'sanctum']);

        $owner->syncPermissions($permissions);
        $admin->syncPermissions($permissions);

    }
}
