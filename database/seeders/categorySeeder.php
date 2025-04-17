<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category')->insert([
            [
                'name' => 'Seni dan Budaya',
                'description' => 'UKM yang bergerak di bidang seni pertunjukan dan budaya.'
            ],
            [
                'name' => 'Kewirausahaan dan Sosial',
                'description' => 'UKM dengan fokus pada pengembangan usaha dan kegiatan sosial.'
            ],
            [
                'name' => 'Bela Negara & Kedisiplinan',
                'description' => 'UKM yang menanamkan nilai bela negara dan kedisiplinan tinggi.'
            ],
            [
                'name' => 'Media, Informasi, dan Akademik',
                'description' => 'UKM di bidang media kampus, literasi, serta pengembangan akademik.'
            ],
            [
                'name' => 'Lingkungan dan Alam Terbuka',
                'description' => 'UKM yang peduli terhadap lingkungan dan kegiatan alam bebas.'
            ],
        ]);
    }
}
