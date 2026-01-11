<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Sprawdza czy admin już istnieje
        if (DB::table('user')->where('login', 'admin')->exists()) {
            echo "Admin już istnieje, pomijam...\n";
            return;
        }
        
        // Dodaje admina
        $adminId = DB::table('user')->insertGetId([
            'login' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'admin@booktracker.pl',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "Dodano admina (login: admin, hasło: admin123)\n";
        
        // Znajduje rolę Admina
        $adminRole = DB::table('role')->where('name', 'Admin')->first();
        
        if ($adminRole) {
            DB::table('user_role')->insert([
                'id_user' => $adminId,
                'id_role' => $adminRole->id_role,
                'assigned_at' => now(),
            ]);
            echo "Przypisano rolę Admina\n";
        }
    }
}