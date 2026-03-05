<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permission_view',
            'permission_create',
            'permission_update',
            'permission_delete',

            'user_view',
            'user_create',
            'user_update',
            'user_delete',

            'user_profile_view',


        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[] = Permission::Create(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $admin->syncPermissions($createdPermissions);



    }
}
