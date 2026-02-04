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
        // 1. Admin User
        User::create([
            'name' => 'Admin Sarpras',
            'email' => 'admin@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Toolman User
        User::create([
            'name' => 'Pak Budi Toolman',
            'email' => 'toolman@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'toolman',
        ]);

        // 3. Student User
        User::create([
            'name' => 'Siswa RPL',
            'email' => 'siswa@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'student',
            'student_id_number' => '12345',
            'class_name' => 'XII RPL 1',
        ]);
    }
}
