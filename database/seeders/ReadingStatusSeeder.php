<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReadingStatusSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('reading_status')->count() > 0) {
           
            return;
        }
        
        DB::table('reading_status')->insert([
            ['name' => 'Do przeczytania'],
            ['name' => 'Czytam'],
            ['name' => 'Przeczytane'],
            ['name' => 'Porzucone'],
        ]);
        
        echo "Dodano statusy czytania\n";
    }
}