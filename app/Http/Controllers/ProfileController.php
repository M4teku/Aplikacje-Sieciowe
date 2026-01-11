<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Wyświetlanie profilu użytkownika
     */
    public function show($id = null)
    {
        // Obsługa przypadku gdy nie podano ID użytkownika
        if ($id === null) {
            if (!Session::has('user_id')) {
                return redirect()->route('login');
            }
            $id = Session::get('user_id');
        }
        
        // WYMUSZENIE odświeżenia sesji
        Session::flush();
        Session::put('user_id', $id);
        Session::save();
        
        // Pobieranie danych użytkownika z relacjami
        $user = User::with(['reviews.book', 'roles', 'booksAdded', 'booksUpdated'])
                    ->findOrFail($id);
        
        // Obliczanie statystyk użytkownika
        $stats = $this->calculateStats($user);
        
        // DEBUG: zapisz statystyki do sesji
        Session::put('debug_stats', $stats);
        Session::put('debug_user_id', $user->id_user);
        
        // Pobierz książki użytkownika do wyświetlenia na profilu
        $userBooks = DB::table('user_book')
                      ->where('id_user', $id)
                      ->get();
        
        $bookIds = $userBooks->pluck('id_book')->toArray();
        $user->trackedBooks = \App\Models\Book::whereIn('id_book', $bookIds)->get();
        
        // Dodaj dane pivot do książek
        foreach ($user->trackedBooks as $book) {
            $userBook = $userBooks->where('id_book', $book->id_book)->first();
            if ($userBook) {
                $book->pivot = (object)[
                    'id_status' => $userBook->id_status ?? null,
                    'progress' => $userBook->progress ?? null,
                    'start_date' => $userBook->start_date ?? null,
                    'planned_end_date' => $userBook->planned_end_date ?? null
                ];
            }
        }
        
        return view('profile.show', compact('user', 'stats'));
    }
    
    /**
     * Obliczanie statystyk użytkownika
     */
    private function calculateStats($user)
    {
        $stats = [
            'total_books' => 0,
            'reading_now' => 0,
            'completed' => 0,
            'want_to_read' => 0,
            'abandoned' => 0,
            'average_rating' => 0,
        ];
        
        // DEBUG: Sprawdź ID użytkownika
        \Log::info("Calculating stats for user ID: " . $user->id_user);
        
        // Pobierz książki użytkownika
        $userBooks = DB::table('user_book')
                      ->where('id_user', $user->id_user)
                      ->get();
        
        // DEBUG: Sprawdź co pobraliśmy
        \Log::info("User books from DB:", $userBooks->toArray());
        
        // Oblicz statystyki
        foreach ($userBooks as $userBook) {
            $stats['total_books']++;
            
            if ($userBook->id_status == 1) {
                $stats['want_to_read']++;
            }
            if ($userBook->id_status == 2) {
                $stats['reading_now']++;
            }
            if ($userBook->id_status == 3) {
                $stats['completed']++;
            }
            if ($userBook->id_status == 4) {
                $stats['abandoned']++;
            }
        }
        
        // DEBUG: Sprawdź statystyki
        \Log::info("Calculated stats:", $stats);
        
        // Średnia ocen
        $reviews = DB::table('review')
                    ->where('id_user', $user->id_user)
                    ->get();
        
        if ($reviews->count() > 0) {
            $totalRating = 0;
            foreach ($reviews as $review) {
                $totalRating += $review->rating;
            }
            $stats['average_rating'] = round($totalRating / $reviews->count(), 2);
        }
        
        return $stats;
    }
    
    /**
     * Wyświetlanie formularza edycji profilu
     */
    public function edit()
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $user = User::find(Session::get('user_id'));
        
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Aktualizacja danych profilu użytkownika
     */
    public function update(Request $request)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $user = User::find(Session::get('user_id'));
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'email' => 'required|email|max:100|unique:user,email,' . $user->id_user . ',id_user',
        ]);
        
        // Aktualizacja rekordu użytkownika
        $user->update($validated);
        
        return redirect()->route('profile.show')
                         ->with('success', 'Profil zaktualizowany!');
    }
}