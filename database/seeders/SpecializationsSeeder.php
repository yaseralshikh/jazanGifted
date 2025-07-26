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
            ['name' => 'لغة عربية'],
            ['name' => 'لغة إنجليزية'],
            ['name' => 'رياضيات'],
            ['name' => 'علوم'],
            ['name' => 'اجتماعيات'],
            ['name' => 'اسلامية'],
            ['name' => 'قرآن'],
            ['name' => 'فنية'],
            ['name' => 'بدنية'],
            ['name' => 'حاسب آلي'],
            ['name' => 'فيزياء'],
            ['name' => 'كيمياء'],
            ['name' => 'أحياء'],
            ['name' => 'علم نفس'],
        ]);
    }
}
