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

            'show_role',
            'create_role',
            'update_role',
            'delete_role',

            'show_user',
            'create_user',
            'update_user',
            'delete_user',

            'show_setting',
            'create_setting',
            'update_setting',
            'delete_setting',

            'show_client',
            'create_client',
            'update_client',
            'delete_client',

            'show_project',
            'create_project',
            'update_project',
            'delete_project',

            'show_product',
            'create_product',
            'update_product',
            'delete_product',

            'show_category',
            'create_category',
            'update_category',
            'delete_category',

            'show_contact',
            'create_contact',
            'update_contact',
            'delete_contact',

        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[] = Permission::firstOrCreate(
                ['name' => $permission]
            );
        }

        $owner = Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);

        $owner->syncPermissions($permissions);

    }
}
