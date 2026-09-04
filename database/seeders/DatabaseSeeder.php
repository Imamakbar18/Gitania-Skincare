<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- Import Hash diletakkan di atas

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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Tambahkan akun admin di sini
        User::create([
            'name' => 'Admin Gitania',
            'email' => 'admin@gitania.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);
    }
}
