<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specializations')->insert([
            ['name' => 'لغة عربية', 'status' => 1],
            ['name' => 'لغة إنجليزية', 'status' => 1],
            ['name' => 'رياضيات', 'status' => 1],
            ['name' => 'علوم', 'status' => 1],
            ['name' => 'اجتماعيات', 'status' => 1],
            ['name' => 'اسلامية', 'status' => 1],
            ['name' => 'قرآن', 'status' => 1],
            ['name' => 'فنية', 'status' => 1],
            ['name' => 'بدنية', 'status' => 1],
            ['name' => 'حاسب آلي', 'status' => 1],
            ['name' => 'فيزياء', 'status' => 1],
            ['name' => 'كيمياء', 'status' => 1],
            ['name' => 'أحياء', 'status' => 1],
            ['name' => 'علم نفس', 'status' => 1],
        ]);
    }
}
