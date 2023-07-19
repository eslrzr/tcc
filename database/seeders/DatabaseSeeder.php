<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AdministrationType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        // Create multiple administration types
        AdministrationType::create([
            'name' => 'Administrador',
        ]);
        AdministrationType::create([
            'name' => 'Contador',
        ]);
        User::factory(1)->create(['administration_type_id' => 1]);
    }
}
