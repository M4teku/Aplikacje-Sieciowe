@extends('layouts.app')

@section('title', 'Przeglądaj książki - BookTracker')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>
            @if(request()->is('/'))
                Książki
            @else
                Wszystkie książki
            @endif
        </h1>
        <p class="lead">Przeglądaj kolekcję książek i dodawaj je do swojej listy</p>
    </div>
</div>

@if(session('success') && (str_contains(session('success'), 'Zalogowano') || str_contains(session('success'), 'Witaj')))
<div class="alert alert-info mb-4" style="background: linear-gradient(to right, rgba(33, 150, 243, 0.15), rgba(66, 165, 245, 0.1)); border: 2px solid #2196F3; border-left: 8px solid #2196F3; border-radius: 8px;">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div style="font-size: 24px; margin-right: 15px;">📚</div>
            <div>
                <strong style="color: #0d47a1;">Witaj w BookTracker!</strong>
                <div style="color: #1565c0;">{{ session('success') }}</div>
            </div>
        </div>
        <div>
            <a href="/profile" class="btn btn-sm btn-primary" style="background: linear-gradient(to bottom, #2196F3, #1976D2); border: 1px solid #0d47a1; padding: 8px 20px;">
                Przejdź do swojego profilu
            </a>
        </div>
    </div>
</div>
@endif

<div class="card mb-4" style="background: rgba(245, 230, 202, 0.9); border: 2px solid #6D4C41; border-radius: 10px;">
    <div class="card-body">
        <form class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label mb-1" style="color: #5D4037; font-weight: 500;">Szukaj książki</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Wpisz tytuł, autora lub opis..." 
                       value="{{ request('search') }}"
                       style="border: 2px solid #8D6E63; padding: 10px;">
            </div>
            
            <div class="col-md-3">
                <label class="form-label mb-1" style="color: #5D4037; font-weight: 500;">Gatunek</label>
                <select name="genre" class="form-select" style="border: 2px solid #8D6E63; padding: 10px;">
                    <option value="all">Wszystkie gatunki</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre }}" 
                                {{ request('genre') == $genre ? 'selected' : '' }}>
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label mb-1" style="color: #5D4037; font-weight: 500;">Sortowanie</label>
                <select name="sort" class="form-select" style="border: 2px solid #8D6E63; padding: 10px;">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                        Najnowsze
                    </option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                        Tytuł A-Z
                    </option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                        Tytuł Z-A
                    </option>
                </select>
            </div>
            
            <div class="col-md-2 d-flex" style="padding-top: 28px; gap: 12px;">
                <button type="submit" class="btn btn-primary flex-grow-1" 
                        style="padding: 10px 15px; border: 2px solid #5D4037;">
                    Szukaj
                </button>
                <a href="/books" class="btn btn-outline-secondary" style="padding: 10px 15px;">
                    Wyczyść
                </a>
            </div>
        </form>
    </div>
</div>

@if($books->count() > 0)
    <div class="row">
        @foreach($books as $book)
        <div class="col-md-4 mb-4">
            <div class="card book-card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <h6 class="card-subtitle mb-2">
                        {{ $book->author }}
                    </h6>
                    
                    <div class="mb-3">
                        <span class="badge bg-warning">
                            {{ $book->genre }}
                        </span>
                        @if($book->reviews_count && $book->reviews_count > 0)
                            <span class="badge bg-success ms-1">
                                {{ $book->reviews_count }} recenzji
                            </span>
                        @endif
                    </div>
                    
                    <p class="card-text">
                        {{ Str::limit($book->description, 150) }}
                    </p>
                    
                    <div class="mt-3">
                        <a href="/books/{{ $book->id_book }}" class="btn btn-primary btn-sm">
                            Szczegóły
                        </a>
                        
                        @if(session('user_id'))
                            <button class="btn btn-outline-warning btn-sm ms-1">
                                Dodaj do listy
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <small class="text-muted">
                        Dodano: {{ $book->created_at->format('d.m.Y') }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @if($books->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
    @endif
    
@else
    <div class="text-center py-5">
        <div class="mb-3">
            📚
        </div>
        <h4>Nie znaleziono książek</h4>
        <p class="text-muted">Spróbuj zmienić kryteria wyszukiwania</p>
        <a href="/books" class="btn btn-primary">
            Wyczyść filtry
        </a>
        
        @if(!session('user_id'))
        <div class="mt-4">
            <p>Chcesz dodawać książki do swojej listy?</p>
            <a href="/register" class="btn btn-success">
                Zarejestruj się za darmo
            </a>
        </div>
        @endif
    </div>
@endif
@endsection