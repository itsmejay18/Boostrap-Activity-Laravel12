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

        User::query()->where('email', 'test@example.com')->delete();

        User::query()->updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'admin',
            'password' => 'admin123',
        ]);
    }
}
