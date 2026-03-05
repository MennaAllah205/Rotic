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
        User::Create(
            [
                'name'     => 'owner',
                'email'    => 'owner@owner.com',
                'phone'    => '01234567890',
                'password' => '1234',
                'is_owner' => true,
            ]
        );
    }
}
