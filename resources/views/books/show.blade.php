@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h1>{{ $book->title }}</h1>
                <p class="lead">{{ $book->author }}</p>
                
                <div class="mb-3">
                    <span class="badge bg-warning" style="font-size: 1rem; padding: 8px 15px;">
                        {{ $book->genre }}
                    </span>
                    
                    @php
                        $avgRating = $book->reviews->avg('rating');
                        $reviewCount = $book->reviews->count();
                    @endphp
                    
                    @if($reviewCount > 0)
                        <span class="badge bg-success ms-2" style="font-size: 1rem; padding: 8px 15px;">
                            ⭐ {{ number_format($avgRating, 1) }}/5 ({{ $reviewCount }} recenzji)
                        </span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <h4>Opis</h4>
                    <p style="font-size: 1.1rem; line-height: 1.6;">{{ $book->description }}</p>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">
                        Dodano: {{ $book->created_at->format('d.m.Y') }} |
                        Przez: {{ $book->creator->login ?? 'Nieznany użytkownik' }}
                    </small>
                </div>
                
                <div class="mt-4">
                    <a href="/books" class="btn btn-secondary">← Powrót do listy</a>
                    
                    @if(session('user_id'))
                        @php
                            $userTracking = \App\Models\UserBook::where('id_user', session('user_id'))
                                ->where('id_book', $book->id_book)
                                ->first();
                        @endphp
                        
                        @if(!$userTracking)
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addToListModal">
                                ➕ Dodaj do mojej listy
                            </button>
                        @else
                            <a href="{{ route('userbooks.mybooks') }}" class="btn btn-info">
                                📚 Masz już w swojej liście
                            </a>
                        @endif
                        
                        
                        @php
                            $userReview = $book->reviews->where('id_user', session('user_id'))->first();
                        @endphp
                        
                        @if(!$userReview)
                            <a href="{{ route('reviews.create', $book->id_book) }}" class="btn btn-primary">
                                ⭐ Oceń książkę
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        
      
        <div class="card">
            <div class="card-body">
                <h3>Recenzje ({{ $reviewCount }})</h3>
                
                @if($reviewCount > 0)
                    @foreach($book->reviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <h5>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    {{ $review->user->login }}
                                </h5>
                                <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            </div>
                            <p class="mt-2">{{ $review->content }}</p>
                            
                            @if(session('user_id') && (session('user_id') == $review->id_user || in_array('Admin', session('user_roles', [])) || in_array('Moderator', session('user_roles', []))))
                                <div class="mt-2">
                                    <a href="{{ route('reviews.edit', $review->id_review) }}" class="btn btn-sm btn-outline-warning">Edytuj</a>
                                    <form action="{{ route('reviews.destroy', $review->id_review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Usunąć recenzję?')">Usuń</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Brak recenzji. Bądź pierwszy!</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
    
        <div class="card mb-4">
            <div class="card-body">
                <h4>Statystyki książki</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">📊 Średnia ocena: <strong>{{ $avgRating ? number_format($avgRating, 1) : 'Brak' }}/5</strong></li>
                    <li class="mb-2">📝 Liczba recenzji: <strong>{{ $reviewCount }}</strong></li>
                    <li class="mb-2">👥 Książka w listach: <strong>{{ $book->trackedByUsers->count() }} użytkowników</strong></li>
                </ul>
            </div>
        </div>
        
       
        @if(session('user_id') && $userReview)
            <div class="card mb-4">
                <div class="card-body">
                    <h4>Twoja recenzja</h4>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $userReview->rating)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                        <strong>{{ $userReview->rating }}/5</strong>
                    </div>
                    <p>{{ $userReview->content }}</p>
                    <div class="mt-3">
                        <a href="{{ route('reviews.edit', $userReview->id_review) }}" class="btn btn-sm btn-warning">Edytuj recenzję</a>
                        <form action="{{ route('reviews.destroy', $userReview->id_review) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Usunąć recenzję?')">Usuń</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        
        
        @if(session('user_id') && $userTracking)
            <div class="card">
                <div class="card-body">
                    <h4>Twoja lista</h4>
                    <p>Status: <strong>
                        @php
                            $status = \App\Models\ReadingStatus::find($userTracking->id_status);
                        @endphp
                        {{ $status->name ?? 'Nieznany' }}
                    </strong></p>
                    <div class="mt-3">
                        <a href="{{ route('userbooks.mybooks') }}" class="btn btn-sm btn-info">Zobacz wszystkie książki w liście</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


@if(session('user_id'))
<div class="modal fade" id="addToListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dodaj "{{ $book->title }}" do swojej listy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('books.add-to-list', $book->id_book) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status czytania</label>
                        <select name="id_status" class="form-select" required>
                            <option value="">Wybierz status...</option>
                            @php
                                $statuses = \App\Models\ReadingStatus::all();
                            @endphp
                            @foreach($statuses as $status)
                                <option value="{{ $status->id_status }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-success">Dodaj do listy</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection