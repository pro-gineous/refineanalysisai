<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\FrameworkSeeder;
use Database\Seeders\FrameworksSeeder;
use Database\Seeders\ReplaceAllFrameworksSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            // FrameworkSeeder::class, // Ya no necesitamos los seeders anteriores de frameworks
            // FrameworksSeeder::class,
            ReplaceAllFrameworksSeeder::class, // Reemplaza todos los frameworks manteniendo la integridad referencial
            AdminUserSeeder::class,
        ]);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
