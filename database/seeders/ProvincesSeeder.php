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
            ['name' => 'وسط جازان'],
            ['name' => 'فرسان'],
            ['name' => 'أبو عريش'],
            ['name' => 'صامطة'],
            ['name' => 'المسارحة والحرث'],
            ['name' => 'العارضة'],
            ['name' => 'صبيا'],
            ['name' => 'بيش'],
            ['name' => 'العيدابي'],
            ['name' => 'الداير'],
            ['name' => 'الدرب'],
        ]);
    }
}
