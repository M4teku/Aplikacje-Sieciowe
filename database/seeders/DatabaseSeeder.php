<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Uruchamia wszystkie seedery w kolejności
        $this->call([
            RoleSeeder::class,
            ReadingStatusSeeder::class,
            UserSeeder::class,
        ]);
        
        
    }
}