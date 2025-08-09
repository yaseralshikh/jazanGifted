<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicWeeksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $weeks = [
            // الفصل الدراسي الأول 1447 (2025-2026)
            [
                'academic_year_id' => 1,
                'week_number' => 1,
                'start_date' => '2025-08-24',
                'end_date' => '2025-08-28',
                'label' => 'الأسبوع التمهيدي للطلاب الجدد',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 2,
                'start_date' => '2025-08-31',
                'end_date' => '2025-09-04',
                'label' => 'بداية الدراسة للجميع - الأسبوع الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 3,
                'start_date' => '2025-09-07',
                'end_date' => '2025-09-11',
                'label' => 'الأسبوع الثاني - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 4,
                'start_date' => '2025-09-14',
                'end_date' => '2025-09-18',
                'label' => 'الأسبوع الثالث - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 5,
                'start_date' => '2025-09-21',
                'end_date' => '2025-09-25',
                'label' => 'الأسبوع الرابع - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 6,
                'start_date' => '2025-09-28',
                'end_date' => '2025-10-02',
                'label' => 'إجازة اليوم الوطني (23 سبتمبر)',
                'status' => false
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 7,
                'start_date' => '2025-10-05',
                'end_date' => '2025-10-09',
                'label' => 'الأسبوع الخامس - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 8,
                'start_date' => '2025-10-12',
                'end_date' => '2025-10-16',
                'label' => 'الأسبوع السادس - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 9,
                'start_date' => '2025-10-19',
                'end_date' => '2025-10-23',
                'label' => 'الأسبوع السابع - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 10,
                'start_date' => '2025-10-26',
                'end_date' => '2025-10-30',
                'label' => 'الأسبوع الثامن - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 11,
                'start_date' => '2025-11-02',
                'end_date' => '2025-11-06',
                'label' => 'الأسبوع التاسع - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 12,
                'start_date' => '2025-11-09',
                'end_date' => '2025-11-13',
                'label' => 'الأسبوع العاشر - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 13,
                'start_date' => '2025-11-16',
                'end_date' => '2025-11-20',
                'label' => 'الأسبوع الحادي عشر - الفصل الأول',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 14,
                'start_date' => '2025-11-23',
                'end_date' => '2025-11-27',
                'label' => 'أسبوع الاختبارات النهائية',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 15,
                'start_date' => '2025-11-30',
                'end_date' => '2025-12-04',
                'label' => 'إجازة بين الفصلين',
                'status' => false
            ],

            // الفصل الدراسي الثاني 1447
            [
                'academic_year_id' => 1,
                'week_number' => 16,
                'start_date' => '2025-12-07',
                'end_date' => '2025-12-11',
                'label' => 'الأسبوع الأول - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 17,
                'start_date' => '2025-12-14',
                'end_date' => '2025-12-18',
                'label' => 'الأسبوع الثاني - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 18,
                'start_date' => '2025-12-21',
                'end_date' => '2025-12-25',
                'label' => 'الأسبوع الثالث - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 19,
                'start_date' => '2025-12-28',
                'end_date' => '2026-01-01',
                'label' => 'الأسبوع الرابع - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 20,
                'start_date' => '2026-01-04',
                'end_date' => '2026-01-08',
                'label' => 'الأسبوع الخامس - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 21,
                'start_date' => '2026-01-11',
                'end_date' => '2026-01-15',
                'label' => 'الأسبوع السادس - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 22,
                'start_date' => '2026-01-18',
                'end_date' => '2026-01-22',
                'label' => 'الأسبوع السابع - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 23,
                'start_date' => '2026-01-25',
                'end_date' => '2026-01-29',
                'label' => 'الأسبوع الثامن - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 24,
                'start_date' => '2026-02-01',
                'end_date' => '2026-02-05',
                'label' => 'الأسبوع التاسع - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 25,
                'start_date' => '2026-02-08',
                'end_date' => '2026-02-12',
                'label' => 'الأسبوع العاشر - الفصل الثاني',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 26,
                'start_date' => '2026-02-15',
                'end_date' => '2026-02-19',
                'label' => 'أسبوع الاختبارات النهائية',
                'status' => true
            ],
            [
                'academic_year_id' => 1,
                'week_number' => 27,
                'start_date' => '2026-02-22',
                'end_date' => '2026-02-26',
                'label' => 'إجازة نهاية العام الدراسي',
                'status' => false
            ]
        ];

        DB::table('academic_weeks')->insert($weeks);
    }
}
