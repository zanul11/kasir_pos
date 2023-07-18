<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            // 'id' => Str::uuid()->toString(),
            'name' => 'Kise Ryota',
            'username' => 'kise',
            'role' => 'super',
            'password' => bcrypt('kise'),
        ]);
    }
}
