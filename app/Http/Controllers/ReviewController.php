<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    /**
     * Wyświetlanie formularza dodawania recenzji
     */
    public function create($bookId)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $book = Book::findOrFail($bookId);
        
        // Sprawdzenie czy użytkownik już dodał recenzję dla tej książki
        $existingReview = Review::where('id_user', Session::get('user_id'))
                                ->where('id_book', $bookId)
                                ->first();
        
        if ($existingReview) {
            return redirect()->route('books.show', $bookId)
                             ->with('error', 'Już dodałeś recenzję dla tej książki.');
        }
        
        return view('reviews.create', compact('book'));
    }
    
    /**
     * Zapis nowej recenzji do bazy
     */
    public function store(Request $request, $bookId)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:4000',
        ]);
        
        // Sprawdzenie czy książka istnieje
        $book = Book::findOrFail($bookId);
        
        // Sprawdzenie czy użytkownik już dodał recenzję
        $existingReview = Review::where('id_user', Session::get('user_id'))
                                ->where('id_book', $bookId)
                                ->first();
        
        if ($existingReview) {
            return redirect()->route('books.show', $bookId)
                             ->with('error', 'Już dodałeś recenzję dla tej książki.');
        }
        
        // Dodanie danych użytkownika i książki
        $validated['id_user'] = Session::get('user_id');
        $validated['id_book'] = $bookId;
        
        // Tworzenie recenzji w bazie
        Review::create($validated);
        
        return redirect()->route('books.show', $bookId)
                         ->with('success', 'Recenzja dodana pomyślnie!');
    }
    
    /**
     * Wyświetlanie formularza edycji recenzji
     */
    public function edit($id)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $review = Review::with('book')->findOrFail($id);
        
        // Sprawdzenie uprawnień użytkownika
        if ($review->id_user != Session::get('user_id') && 
            !in_array('Admin', Session::get('user_roles', [])) &&
            !in_array('Moderator', Session::get('user_roles', []))) {
            return redirect()->route('books.show', $review->id_book)
                             ->with('error', 'Brak uprawnień do edycji tej recenzji.');
        }
        
        return view('reviews.edit', compact('review'));
    }
    
    /**
     * Aktualizacja recenzji w bazie
     */
    public function update(Request $request, $id)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $review = Review::findOrFail($id);
        
        // Sprawdzenie uprawnień użytkownika
        if ($review->id_user != Session::get('user_id') && 
            !in_array('Admin', Session::get('user_roles', [])) &&
            !in_array('Moderator', Session::get('user_roles', []))) {
            return redirect()->route('books.show', $review->id_book)
                             ->with('error', 'Brak uprawnień do edycji tej recenzji.');
        }
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:4000',
        ]);
        
        // Aktualizacja recenzji
        $review->update($validated);
        
        return redirect()->route('books.show', $review->id_book)
                         ->with('success', 'Recenzja zaktualizowana!');
    }
    
    /**
     * Usuwanie recenzji z bazy
     */
    public function destroy($id)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $review = Review::findOrFail($id);
        
        // Sprawdzenie uprawnień użytkownika
        if ($review->id_user != Session::get('user_id') && 
            !in_array('Admin', Session::get('user_roles', [])) &&
            !in_array('Moderator', Session::get('user_roles', []))) {
            return redirect()->route('books.show', $review->id_book)
                             ->with('error', 'Brak uprawnień do usunięcia tej recenzji.');
        }
        
        $bookId = $review->id_book;
        $review->delete();
        
        return redirect()->route('books.show', $bookId)
                         ->with('success', 'Recenzja usunięta!');
    }
}