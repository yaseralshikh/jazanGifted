<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء المستخدم
        $user = User::create([
            'name'              => 'ياسر محمد احمد الشيخ',
            'email'             => 'yaseralshikh@gmail.com',
            'national_id'       => '1047092406',
            'phone'             => '966505887741',
            'gender'            =>  'male',
            'education_region_id' => 1, // ربط المستخدم بالمنطقة التعليمية الأولى
            'password'          => bcrypt('123123123'),
            'email_verified_at' => now(),
            'status'            => 1,  
        ]);

        $user->provinces()->attach(1); // ربط المستخدم بالمحافظة الأولى
        $user->addRole('superadmin');
    }
}
