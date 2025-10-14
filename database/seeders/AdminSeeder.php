<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('email', 'admin@template.test')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@template.test',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin account created successfully!');
            $this->command->info('📧 Email: admin@template.test');
            $this->command->info('🔑 Password: admin123');
        } else {
            $this->command->warn('⚠️  Admin account already exists!');
        }
    }
}
