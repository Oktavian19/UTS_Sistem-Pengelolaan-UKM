<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ukmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ukm')->insert([
            [
                'name' => 'Seni Theatrisic',
                'description' => 'UKM yang bergerak di bidang seni teater dan pertunjukan.',
                'category_id' => 1, // ID dari tabel category_id, sesuaikan
                'email' => 'theatrisic@ukm.com',
                'phone' => '081234567890',
                'website' => 'https://theatrisic.ukm.com',
                'logo_path' => 'logos/theatrisic.png',
                'is_active' => true,
                'created_by' => 1 // ID dari tabel admin
            ],
            [
                'name' => 'Usaha Mahasiswa',
                'description' => 'UKM penggerak jiwa kewirausahaan di lingkungan kampus.',
                'category_id' => 2,
                'email' => 'usaha@ukm.com',
                'phone' => '081298765432',
                'website' => null,
                'logo_path' => null,
                'is_active' => true,
                'created_by' => 2
            ],
            [
                'name' => 'OPA Ganendra Giri',
                'description' => 'UKM pencinta alam yang berfokus pada kegiatan luar ruangan.',
                'category_id' => 5,
                'email' => 'opa@ukm.com',
                'phone' => '082112345678',
                'website' => 'https://opa.ukm.com',
                'logo_path' => 'logos/opa.png',
                'is_active' => true,
                'created_by' => 3
            ],
        ]);
    }
}
