<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Perawat Indah',
            'username' => 'perawat',
            'email' => 'perawat@example.com',
            'password' => bcrypt('password'),
            'role' => 'perawat',
        ]);

        User::factory()->create([
            'name' => 'Dr. Sp. Rad Ahmad',
            'username' => 'dokter',
            'email' => 'dokter@example.com',
            'password' => bcrypt('password'),
            'role' => 'dokter',
        ]);

        \App\Models\Patient::create([
            'medical_record_number' => '12-34-56',
            'name' => 'Budi Santoso',
            'gender' => 'L',
            'date_of_birth' => '1985-06-15',
            'phone' => '08123456789',
            'address' => 'Jl. Sudirman No. 12, Pekanbaru',
        ]);

        \App\Models\Patient::create([
            'medical_record_number' => '78-90-12',
            'name' => 'Siti Aminah',
            'gender' => 'P',
            'date_of_birth' => '1990-12-05',
            'phone' => '08987654321',
            'address' => 'Jl. Tuanku Tambusai No. 45, Pekanbaru',
        ]);
    }
}
