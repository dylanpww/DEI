<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@crave.com'], 
            [
                'username' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        User::updateOrCreate(
            ['email' => 'partner@crave.com'],
            [
                'username' => 'Crave Partner Resto',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]
        );
        User::updateOrCreate(
            ['email' => 'user@crave.com'], 
            [
                'username' => 'user',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
