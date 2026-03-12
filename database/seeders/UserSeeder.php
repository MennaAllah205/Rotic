<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'email' => 'owner@owner.com',
                'name' => 'owner',
                'phone' => '01234567890',
                'password' => '12345678',
                'is_owner' => true,
            ]
        );

        $user->assignRole('owner');

    }
}
