<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            ['name' => 'Fakultas Teknik'],
            ['name' => 'Fakultas Ekonomi dan Bisnis'],
            ['name' => 'Fakultas MIPA'],
            ['name' => 'Fakultas Ilmu Sosial dan Politik'],
            ['name' => 'Fakultas Hukum'],
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }

        $this->command->info('✅ Faculties seeded successfully!');
    }
}
