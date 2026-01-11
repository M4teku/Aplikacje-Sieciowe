<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        //  Sprawdza, czy role już istnieją
        if (DB::table('role')->count() > 0) {
            echo "Role już istnieją\n";
            return;
        }
        
        DB::table('role')->insert([
            [
                'name' => 'Admin', 
                'is_active' => 1, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Moderator', 
                'is_active' => 1, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Czytelnik', 
                'is_active' => 1, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
        
        echo "Dodano role: Admin, Moderator, Czytelnik\n";
    }
}