<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = [
            [
                'name' => '1447',
                'start_date' => '2025-08-24', // تاريخ بداية العام الدراسي (هجري 1447/01/01 تقريباً)
                'end_date' => '2026-05-31', // تاريخ نهاية العام الدراسي
                'status' => 1, // 1 = نشط
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('academic_years')->insert($academicYears);
    }
}
