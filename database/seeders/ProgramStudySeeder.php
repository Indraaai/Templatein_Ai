<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;

class ProgramStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programStudies = [
            // Fakultas Teknik (ID: 1)
            ['faculty_id' => 1, 'name' => 'Teknik Informatika'],
            ['faculty_id' => 1, 'name' => 'Sistem Informasi'],
            ['faculty_id' => 1, 'name' => 'Teknik Elektro'],
            ['faculty_id' => 1, 'name' => 'Teknik Sipil'],

            // Fakultas Ekonomi (ID: 2)
            ['faculty_id' => 2, 'name' => 'Manajemen'],
            ['faculty_id' => 2, 'name' => 'Akuntansi'],
            ['faculty_id' => 2, 'name' => 'Ekonomi Pembangunan'],

            // Fakultas MIPA (ID: 3)
            ['faculty_id' => 3, 'name' => 'Matematika'],
            ['faculty_id' => 3, 'name' => 'Fisika'],
            ['faculty_id' => 3, 'name' => 'Kimia'],
            ['faculty_id' => 3, 'name' => 'Biologi'],

            // Fakultas Ilmu Sosial dan Politik (ID: 4)
            ['faculty_id' => 4, 'name' => 'Ilmu Komunikasi'],
            ['faculty_id' => 4, 'name' => 'Ilmu Pemerintahan'],
            ['faculty_id' => 4, 'name' => 'Sosiologi'],

            // Fakultas Hukum (ID: 5)
            ['faculty_id' => 5, 'name' => 'Ilmu Hukum'],
        ];

        foreach ($programStudies as $prodi) {
            ProgramStudy::create($prodi);
        }

        $this->command->info('✅ Program Studies seeded successfully!');
    }
}
