<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'username' => 'admin',
                'password_hash' => Hash::make('password123'),
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ],
            [
                'username' => 'admin2',
                'password_hash' => Hash::make('password123'),
                'name' => 'Admin Dua',
                'email' => 'admin2@example.com',
            ],
            [
                'username' => 'admin3',
                'password_hash' => Hash::make('password123'),
                'name' => 'Admin Tiga',
                'email' => 'admin3@example.com',
            ]
        ]);
    }
}
