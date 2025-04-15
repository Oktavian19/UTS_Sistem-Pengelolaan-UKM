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
                'name' => 'UKM Musik Kampus',
                'description' => 'Unit kegiatan mahasiswa yang fokus pada musik dan pertunjukan.',
                'contact_person' => 'Andi Musik',
                'email' => 'musik@ukm.ac.id',
                'phone' => '081234567891',
                'website' => 'https://ukmmusik.example.com',
                'logo_path' => 'logos/ukm_musik.png',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'UKM Olahraga',
                'description' => 'Mewadahi mahasiswa dalam kegiatan olahraga seperti futsal, basket, dll.',
                'contact_person' => 'Budi Atlet',
                'email' => 'olahraga@ukm.ac.id',
                'phone' => '082345678912',
                'website' => null,
                'logo_path' => null,
                'status' => 'active',
                'created_by' => 2,
            ],
            [
                'name' => 'UKM Bahasa dan Sastra',
                'description' => 'Mempromosikan kegiatan linguistik, sastra dan diskusi budaya.',
                'contact_person' => 'Citra Sastra',
                'email' => 'sastra@ukm.ac.id',
                'phone' => '083456789123',
                'website' => 'https://ukmsastra.example.com',
                'logo_path' => 'logos/ukm_sastra.png',
                'status' => 'inactive',
                'created_by' => 3,
            ]
        ]);
    }
}
