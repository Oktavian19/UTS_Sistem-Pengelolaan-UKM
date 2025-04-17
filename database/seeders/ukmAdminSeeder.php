<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ukmAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ukm_admin')->insert([
            [
                'nim' => 21430001,
                'name' => 'Rizky Maulana',
                'password_hash' => Hash::make('password123'),
                'phone' => '081234567890',
                'email' => 'rizky@ukm.com',
                'ukm_id' => 1, // ID UKM: Seni Theatrisic
                'photo' => 'photos/rizky.jpg',
                'is_active' => true
            ],
            [
                'nim' => 21430002,
                'name' => 'Siti Aminah',
                'password_hash' => Hash::make('password123'),
                'phone' => '089876543210',
                'email' => 'siti@ukm.com',
                'ukm_id' => 2, // ID UKM: Usaha Mahasiswa
                'photo' => null,
                'is_active' => true
            ],
            [
                'nim' => 21430003,
                'name' => 'Dewi Lestari',
                'password_hash' => Hash::make('password123'),
                'phone' => '082112345678',
                'email' => 'dewi@ukm.com',
                'ukm_id' => 3, // ID UKM: OPA Ganendra Giri
                'photo' => 'photos/dewi.png',
                'is_active' => true
            ]
        ]);
    }
}
