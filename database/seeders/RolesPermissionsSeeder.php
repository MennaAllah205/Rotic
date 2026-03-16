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

            'client_create',
            'client_update',
            'client_delete',

            'projects_create',
            'projects_update',
            'projects_delete',

            'products_create',
            'products_update',
            'products_delete',

            'contact_us_show',
            'contact_us_create',
            'contact_us_update',
            'contact_us_delete',

            'categories_create',
            'categories_update',
            'categories_delete',

            'blogs_create',
            'blogs_update',
            'blogs_delete',

            'testimonial_create',
            'testimonial_update',
            'testimonial_delete',

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
