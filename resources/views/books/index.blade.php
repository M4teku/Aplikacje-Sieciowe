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

<!-- Wyszukiwarka -->
<div class="card mb-4" style="background: rgba(245, 230, 202, 0.9); border: 2px solid #6D4C41;">
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" 
                       placeholder="Szukaj po tytule lub autorze..." 
                       value="{{ request('search') }}">
            </div>
            
            <div class="col-md-3">
                <select name="genre" class="form-select">
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
                <select name="sort" class="form-select">
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
            
            <div class="col-md-2">
                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary">
                        Szukaj
                    </button>
                    <a href="/books" class="btn btn-outline-secondary">
                        Wyczyść
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('user_id'))
<div class="alert alert-warning mb-4">
    <div class="row">
        <div class="col-md-12">
            <a href="/profile" class="btn btn-sm btn-outline-dark float-end">
                Przejdź do swojego profilu
            </a>
        </div>
    </div>
</div>
@endif

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