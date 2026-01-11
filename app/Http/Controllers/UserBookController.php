<?php

namespace App\Http\Controllers;

use App\Models\UserBook;
use App\Models\Book;
use App\Models\ReadingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class UserBookController extends Controller
{
    /**
     * Dodawanie książki do listy użytkownika
     */
    public function store(Request $request, $bookId)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        // Sprawdzenie czy książka istnieje
        $book = Book::findOrFail($bookId);
        
        // Sprawdzenie czy użytkownik już śledzi tę książkę
        $existing = UserBook::where('id_user', Session::get('user_id'))
                            ->where('id_book', $bookId)
                            ->first();
        
        if ($existing) {
            return redirect()->route('books.show', $bookId)
                             ->with('error', 'Już śledzisz tę książkę.');
        }
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'id_status' => 'required|exists:reading_status,id_status',
        ]);
        
        // Dodanie danych użytkownika
        $validated['id_user'] = Session::get('user_id');
        $validated['id_book'] = $bookId;
        
        // Tworzenie rekordu śledzenia książki
        UserBook::create($validated);
        
        return redirect()->route('books.show', $bookId)
                         ->with('success', 'Książka dodana do Twojej listy!');
    }
    
    /**
     * Aktualizacja statusu czytania książki
     */
    public function update(Request $request, $bookId)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $userBook = UserBook::where('id_user', Session::get('user_id'))
                            ->where('id_book', $bookId)
                            ->firstOrFail();
        
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'id_status' => 'required|exists:reading_status,id_status',
        ]);
        
        // Aktualizacja rekordu śledzenia
        $userBook->update($validated);
        
        // Odświeżenie sesji
        Session::save();
        
        return redirect()->route('userbooks.mybooks')
                         ->with('success', 'Status zaktualizowany!');
    }
    
    /**
     * Usuwanie książki z listy użytkownika
     */
    public function destroy($bookId)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $userBook = UserBook::where('id_user', Session::get('user_id'))
                            ->where('id_book', $bookId)
                            ->firstOrFail();
        
        // Usuwanie rekordu śledzenia
        $userBook->delete();
        
        // Odświeżenie sesji
        Session::save();
        
        return redirect()->route('userbooks.mybooks')
                         ->with('success', 'Książka usunięta z Twojej listy.');
    }
    
    /**
     * Wyświetlanie listy książek użytkownika według statusu
     */
    public function myBooks(Request $request)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        // Pobieranie książek użytkownika
        $query = UserBook::with(['book', 'status'])
                        ->where('id_user', Session::get('user_id'));
        
        // Filtrowanie po statusie
        if ($request->has('status') && $request->status != 'all') {
            $query->where('id_status', $request->status);
        }
        
        $userBooks = $query->paginate(20);
        $statuses = ReadingStatus::all();
        
        return view('userbooks.index', compact('userBooks', 'statuses'));
    }

    /**
     * Wyświetlanie formularza edycji książki w liście
     */
    public function edit($bookId)
    {
        // Weryfikacja zalogowania użytkownika
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $userBook = UserBook::where('id_user', Session::get('user_id'))
                            ->where('id_book', $bookId)
                            ->firstOrFail();
        
        $statuses = ReadingStatus::all();
        
        return view('userbooks.edit', compact('userBook', 'statuses'));
    }
}