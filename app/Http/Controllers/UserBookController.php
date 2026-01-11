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
        
        // Walidacja kontekstowa - sprawdzenie dat
        if ($request->has('planned_end_date')) {
            $validated['planned_end_date'] = $request->planned_end_date;
            
            // Sprawdzenie czy data zakończenia nie jest w przeszłości
            if (strtotime($validated['planned_end_date']) < strtotime(date('Y-m-d'))) {
                return back()->withErrors([
                    'planned_end_date' => 'Data zakończenia nie może być w przeszłości.'
                ])->withInput();
            }
        }
        
        if ($request->has('start_date')) {
            $validated['start_date'] = $request->start_date;
            
            // Sprawdzenie czy data rozpoczęcia nie jest późniejsza niż data zakończenia
            if (isset($validated['planned_end_date']) && 
                strtotime($validated['start_date']) > strtotime($validated['planned_end_date'])) {
                return back()->withErrors([
                    'start_date' => 'Data rozpoczęcia nie może być późniejsza niż data zakończenia.'
                ])->withInput();
            }
        }
        
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
            'id_status' => 'sometimes|exists:reading_status,id_status',
            'progress' => 'sometimes|integer|min:0|max:100',
            'start_date' => 'sometimes|date|nullable',
            'planned_end_date' => 'sometimes|date|nullable',
        ]);
        
        // Walidacja kontekstowa - sprawdzenie progresu
        if (isset($validated['progress'])) {
            // Sprawdzenie czy progres jest w zakresie 0-100
            if ($validated['progress'] < 0 || $validated['progress'] > 100) {
                return back()->withErrors([
                    'progress' => 'Progres musi być w zakresie 0-100%.'
                ])->withInput();
            }
            
            // Automatyczna zmiana statusu na podstawie progresu
            if ($validated['progress'] == 100 && $userBook->id_status != 3) {
                $validated['id_status'] = 3; // Przeczytane
            }
        }
        
        // Walidacja kontekstowa - sprawdzenie dat
        if (isset($validated['planned_end_date']) && $validated['planned_end_date']) {
            // Sprawdzenie czy data zakończenia nie jest w przeszłości
            if (strtotime($validated['planned_end_date']) < strtotime(date('Y-m-d'))) {
                return back()->withErrors([
                    'planned_end_date' => 'Data zakończenia nie może być w przeszłości.'
                ])->withInput();
            }
            
            // Sprawdzenie relacji dat rozpoczęcia i zakończenia
            if (isset($validated['start_date']) && $validated['start_date'] && 
                strtotime($validated['start_date']) > strtotime($validated['planned_end_date'])) {
                return back()->withErrors([
                    'start_date' => 'Data rozpoczęcia nie może być późniejsza niż data zakończenia.'
                ])->withInput();
            }
        }
        
        // Aktualizacja rekordu śledzenia
        $userBook->update($validated);
        
        return redirect()->route('books.show', $bookId)
                         ->with('success', 'Status czytania zaktualizowany!');
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
        
        return redirect()->route('books.show', $bookId)
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
}