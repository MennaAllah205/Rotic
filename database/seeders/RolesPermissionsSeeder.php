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

            'permission_show',
            'permission_create',
            'permission_update',
            'permission_delete',

            'user_show',
            'user_create',
            'user_update',
            'user_delete',

            'user_profile_show',

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
