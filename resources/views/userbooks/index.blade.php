@extends('layouts.app')

@section('title', 'Moje książki - BookTracker')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Moje książki</h1>
        <p class="lead">Książki które dodałeś do swojej listy</p>
    </div>
</div>

<!-- Filtry -->
<div class="card mb-4" style="background: rgba(245, 230, 202, 0.9); border: 2px solid #6D4C41; border-radius: 10px;">
    <div class="card-body">
        <form class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label mb-1" style="color: #5D4037; font-weight: 500;">Status</label>
                <select name="status" class="form-select" style="border: 2px solid #8D6E63; padding: 10px;">
                    <option value="all">Wszystkie statusy</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id_status }}" {{ request('status') == $status->id_status ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2 d-flex" style="padding-top: 28px; gap: 12px;">
                <button type="submit" class="btn btn-primary flex-grow-1" style="padding: 10px 15px; border: 2px solid #5D4037;">
                    Filtruj
                </button>
                <a href="/mybooks" class="btn btn-outline-secondary" style="padding: 10px 15px;">
                    Wyczyść
                </a>
            </div>
        </form>
    </div>
</div>

@if($userBooks->count() > 0)
    <div class="row">
        @foreach($userBooks as $userBook)
        <div class="col-md-4 mb-4">
            <div class="card book-card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $userBook->book->title }}</h5>
                    <h6 class="card-subtitle mb-2">
                        {{ $userBook->book->author }}
                    </h6>
                    
                    <div class="mb-3">
                        <span class="badge bg-warning">
                            {{ $userBook->book->genre }}
                        </span>
                        <span class="badge bg-{{ 
                            $userBook->id_status == 3 ? 'success' : 
                            ($userBook->id_status == 2 ? 'warning' : 'secondary')
                        }} ms-1">
                            {{ $userBook->status->name }}
                        </span>
                    </div>
                    
                    <p class="card-text">
                        {{ Str::limit($userBook->book->description, 150) }}
                    </p>
                    
                    <div class="mt-3">
                        <a href="/books/{{ $userBook->book->id_book }}" class="btn btn-primary btn-sm">
                            Szczegóły książki
                        </a>
                        
                        <a href="{{ route('userbooks.edit', $userBook->book->id_book) }}" class="btn btn-warning btn-sm ms-1">
                            Edytuj status
                        </a>
                        
                        <form action="{{ route('userbooks.destroy', $userBook->book->id_book) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm ms-1" onclick="return confirm('Usunąć książkę z listy?')">
                                Usuń z listy
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Usunięto footer z datą -->
            </div>
        </div>
        @endforeach
    </div>
    
    @if($userBooks->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $userBooks->links() }}
    </div>
    @endif
    
@else
    <div class="text-center py-5">
        <div class="mb-3">
            📚
        </div>
        <h4>Nie masz jeszcze książek w swojej liście</h4>
        <p class="text-muted">Dodaj książki do śledzenia swojego postępu w czytaniu</p>
        <a href="/books" class="btn btn-primary">Przeglądaj książki</a>
    </div>
@endif

<div class="mt-4">
    <a href="/profile" class="btn btn-secondary">← Powrót do profilu</a>
</div>
@endsection