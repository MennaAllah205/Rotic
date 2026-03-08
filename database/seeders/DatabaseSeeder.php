<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            RolesPermissionsSeeder::class,
            UserSeeder::class,
        ]);

        $owner = User::first();
        $user  = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'phone'    => '0101234567',
            'password' => '123456',

        ]);

        $owner->assignRole('admin');
        $user->assignRole('admin');
    }
}
