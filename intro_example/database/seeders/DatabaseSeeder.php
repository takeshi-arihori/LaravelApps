<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ループで毎回新しいフェイクデータを生成
        for ($i = 0; $i < 50; $i++) {
            User::factory()->create([
                'username' => fake()->unique()->userName(),
                'description' => fake()->unique()->sentence(),
                'profile_path' => fake()->unique()->imageUrl(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
