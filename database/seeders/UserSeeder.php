<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'username' => 'admin',
            'namalengkap' => 'Administrator',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // Create Siswa User for testing
        User::create([
            'username' => 'siswa',
            'namalengkap' => 'Siswa Contoh',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        // Create 100 random users
        User::factory(100)->create();
    }
}
