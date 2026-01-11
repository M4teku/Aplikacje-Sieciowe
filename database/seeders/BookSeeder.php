<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Sprawdź czy są już książki
        if (DB::table('book')->count() > 0) {
            echo "⏭️  Książki już istnieją, pomijam...\n";
            return;
        }
        
        // Dodaj testowe książki
        DB::table('book')->insert([
            [
                'title' => 'Wiedźmin: Ostatnie życzenie',
                'author' => 'Andrzej Sapkowski',
                'genre' => 'Fantasy',
                'description' => 'Pierwszy tom przygód Geralta z Rivii, łowcy potworów.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Harry Potter i Kamień Filozoficzny',
                'author' => 'J.K. Rowling',
                'genre' => 'Fantasy',
                'description' => 'Pierwsza część serii o młodym czarodzieju Harrym Potterze.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Zbrodnia i kara',
                'author' => 'Fiodor Dostojewski',
                'genre' => 'Klasyka',
                'description' => 'Psychologiczna powieść o morderstwie i odkupieniu.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Metro 2033',
                'author' => 'Dmitry Glukhovsky',
                'genre' => 'Post-apokaliptyczne',
                'description' => 'Survival w moskiewskim metrze po wojnie nuklearnej.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Pan Tadeusz',
                'author' => 'Adam Mickiewicz',
                'genre' => 'Klasyka',
                'description' => 'Epopeja narodowa opisująca życie polskiej szlachty.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Gra o tron',
                'author' => 'George R.R. Martin',
                'genre' => 'Fantasy',
                'description' => 'Pierwszy tom sagi Pieśni Lodu i Ognia.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'genre' => 'Dystopia',
                'description' => 'Powieść o totalitarnym społeczeństwie pod stałym nadzorem.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Hobbit',
                'author' => 'J.R.R. Tolkien',
                'genre' => 'Fantasy',
                'description' => 'Przygody hobbita Bilba Bagginsa w Śródziemiu.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Duma i uprzedzenie',
                'author' => 'Jane Austen',
                'genre' => 'Romans',
                'description' => 'Klasyczna powieść obyczajowa o miłości i przesądach.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Mistrz i Małgorzata',
                'author' => 'Michaił Bułhakow',
                'genre' => 'Klasyka',
                'description' => 'Satyrą na społeczeństwo sowieckie z elementami fantasy.',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        
       
    }
}