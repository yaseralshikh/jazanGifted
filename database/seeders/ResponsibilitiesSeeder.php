<?php

namespace Database\Seeders;

use App\Models\Responsibility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResponsibilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $responsibilities = [
            [
                'title' => 'إدارة البرنامج',
                'code' => 'program_manager',
                'description' => 'متابعة التنفيذ والإشراف العام على البرنامج.',
                'scope_type' => 'program',
                'scope_id' => null,
            ],
            [
                'title' => 'مدير مدرسة',
                'code' => 'school_principal',
                'description' => 'متابعة الطلبة وتقييم البرامج داخل المدرسة.',
                'scope_type' => 'school',
                'scope_id' => null,
            ],
            [
                'title' => 'منسق الموهوبين',
                'code' => 'gifted_coordinator',
                'description' => 'تنسيق برامج الموهوبين وتسجيل الطلاب.',
                'scope_type' => 'school',
                'scope_id' => null,
            ],
            [
                'title' => 'مشرف البرنامج',
                'code' => 'program_supervisor',
                'description' => 'مراجعة بيانات الطلاب ومتابعة الأداء.',
                'scope_type' => 'program',
                'scope_id' => null,
            ],
        ];

        foreach ($responsibilities as $item) {
            Responsibility::updateOrCreate(
                ['code' => $item['code']],
                [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'scope_type' => $item['scope_type'],
                    'scope_id' => $item['scope_id'],
                    'active' => true,
                ]
            );
        }
    }
}
