<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['creator'])
                    ->select('book.*')
                    ->selectRaw('(SELECT COUNT(*) FROM review WHERE review.id_book = book.id_book) as reviews_count');
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->has('genre') && $request->genre != 'all') {
            $query->where('genre', $request->genre);
        }
        
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $books = $query->paginate(12);
        $genres = Book::select('genre')->distinct()->orderBy('genre')->pluck('genre');
        
        return view('books.index', compact('books', 'genres'));
    }
    
    public function show($id)
    {
        $book = Book::with(['creator', 'reviews.user'])->findOrFail($id);
        
        return view('books.show', compact('book'));
    }
    
    public function create()
    {
        if (!Session::has('user_roles') || 
            !(in_array('Moderator', Session::get('user_roles')) || 
              in_array('Admin', Session::get('user_roles')))) {
            return redirect()->route('books.index')->with('error', 'Brak uprawnień.');
        }
        
        return view('books.create');
    }
    
    public function store(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:256',
            'author' => 'required|string|max:256',
            'genre' => 'required|string|max:100',
            'description' => 'required|string|max:4000',
        ]);
        
        $validated['created_by'] = Session::get('user_id');
        
        Book::create($validated);
        
        return redirect()->route('books.index')
                         ->with('success', 'Książka dodana pomyślnie!');
    }
    
    public function edit($id)
    {
        if (!Session::has('user_roles') || 
            !(in_array('Moderator', Session::get('user_roles')) || 
              in_array('Admin', Session::get('user_roles')))) {
            return redirect()->route('books.index')->with('error', 'Brak uprawnień.');
        }
        
        $book = Book::findOrFail($id);
        
        return view('books.edit', compact('book'));
    }
    
    public function update(Request $request, $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        
        $book = Book::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:256',
            'author' => 'required|string|max:256',
            'genre' => 'required|string|max:100',
            'description' => 'required|string|max:4000',
        ]);
        
        $validated['updated_by'] = Session::get('user_id');
        
        $book->update($validated);
        
        return redirect()->route('books.show', $book->id_book)
                         ->with('success', 'Książka zaktualizowana!');
    }
    
    public function destroy($id)
    {
        if (!Session::has('user_roles') || !in_array('Admin', Session::get('user_roles'))) {
            return redirect()->route('books.index')->with('error', 'Brak uprawnień.');
        }
        
        $book = Book::findOrFail($id);
        $book->delete();
        
        return redirect()->route('books.index')
                         ->with('success', 'Książka usunięta!');
    }
}