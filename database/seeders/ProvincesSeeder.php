<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->insert([
            ['name' => 'وسط جازان', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'أبو عريش', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'صامطة', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'المسارحة والحرث', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'العارضة', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'فرسان', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'صبيا', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'بيش', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'الريث', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'العيدابي', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'الداير', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'ضمد', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'هروب', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'فيفا', 'education_region_id' => 1, 'status' => 1],
            ['name' => 'الدرب', 'education_region_id' => 1, 'status' => 1],
        ]);
    }
}
