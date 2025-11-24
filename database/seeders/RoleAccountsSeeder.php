<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAccountsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'peran' => 'Admin'
        ]);

        // Create Instruktur account
        User::create([
            'name' => 'Instruktur User',
            'email' => 'instruktur@example.com',
            'password' => Hash::make('password'),
            'peran' => 'Instruktur'
        ]);

        // Create Peserta account
        User::create([
            'name' => 'Peserta User',
            'email' => 'peserta@example.com',
            'password' => Hash::make('password'),
            'peran' => 'Peserta'
        ]);
    }
}