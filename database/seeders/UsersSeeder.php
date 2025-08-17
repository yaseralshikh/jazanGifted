<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تأكد أن المحافظات موجودة مسبقًا بآيديات: 1,2,3
        // توزيع: 50 وسط جازان (1) + 25 أبو عريش (2) + 25 صامطة (3)
        $plan = [
            1 => 50,
            2 => 25,
            3 => 25,
        ];

        $firstNames  = ['محمد','أحمد','علي','خالد','عبدالله','سعيد','حسن','فهد','يوسف','إبراهيم','عبدالرحمن','صالح','ناصر','تركي','أنس','مازن'];
        $middleParts = ['بن','آل',''];
        $lastNames   = ['القرشي','العسيري','الشريف','الحربي','الغامدي','الشهري','العتيبي','الحارثي','المطيري','الزهراني','الهاشمي','الأنصاري'];

        $genders   = ['male','female'];
        $userTypes = ['student','teacher','school_manager','supervisor'];

        $usedNationalIds = [];

        $emailCounter = 1;
        foreach ($plan as $provinceId => $count) {
            for ($i = 0; $i < $count; $i++) {

                $name    = $this->arabicName($firstNames, $middleParts, $lastNames);
                $gender  = $genders[array_rand($genders)];
                $phone   = '9665' . random_int(10000000, 99999999);

                // national_id: يبدأ بـ 10 ومجموعه 10 خانات (أي 8 خانات عشوائية بعدها)
                $nationalId = $this->uniqueNationalId($usedNationalIds);

                // email عشوائي + رقم للتأكد من uniqueness
                $email = 'user' . $emailCounter . '_' . Str::lower(Str::random(6)) . '@example.com';
                $emailCounter++;

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'national_id' => $nationalId,
                    'education_region_id' => 1,
                    'gender' => $gender,
                    'password' => Hash::make('123123123'),
                    'user_type' => $userTypes[array_rand($userTypes)],
                    'status' => 1,
                ]);

                // ربط المحافظة في جدول الـ pivot
                // تأكد أن لديك علاقة provinces() في نموذج User:
                // public function provinces() { return $this->belongsToMany(\App\Models\Province::class); }
                $user->provinces()->attach($provinceId);
            }
        }
    }

    private function arabicName(array $first, array $middle, array $last): string
    {
        return trim(
            $first[array_rand($first)] . ' ' .
            $middle[array_rand($middle)] . ' ' .
            $last[array_rand($last)]
        );
    }

    private function uniqueNationalId(array &$used): string
    {
        // يُنتج قيمة فريدة من 10 خانات تبدأ بـ 10
        do {
            $nid = '10' . str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (isset($used[$nid]));

        $used[$nid] = true;
        return $nid;
    }   
}
