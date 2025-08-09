<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\LaratrustSeeder;
use Database\Seeders\ProvincesSeeder;
use Database\Seeders\SpecializationsSeeder;
use Database\Seeders\ResponsibilitiesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        $this->call(EducationRegionSeeder::class);
        $this->call(ProvincesSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SpecializationsSeeder::class);
        $this->call(ResponsibilitiesSeeder::class);
        $this->call(AcademicYearSeeder::class);
        $this->call(AcademicWeeksSeeder::class);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
