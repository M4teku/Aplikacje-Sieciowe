<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        
        // Pobieranie danych użytkownika z relacjami
        $user = User::with(['reviews.book', 'trackedBooks.status'])->findOrFail($id);
        
        // Obliczanie statystyk użytkownika
        $stats = $this->calculateStats($user);
        
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
            'average_rating' => 0,
        ];
        
        // Obliczanie liczby książek w różnych statusach
        if ($user->trackedBooks) {
            foreach ($user->trackedBooks as $tracked) {
                $stats['total_books']++;
                
                if ($tracked->status && $tracked->status->name == 'Czytam') {
                    $stats['reading_now']++;
                }
                
                if ($tracked->status && $tracked->status->name == 'Przeczytane') {
                    $stats['completed']++;
                }
            }
        }
        
        // Obliczanie średniej oceny
        if ($user->reviews && count($user->reviews) > 0) {
            $totalRating = 0;
            foreach ($user->reviews as $review) {
                $totalRating += $review->rating;
            }
            $stats['average_rating'] = round($totalRating / count($user->reviews), 2);
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