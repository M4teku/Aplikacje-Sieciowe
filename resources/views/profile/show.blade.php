@extends('layouts.app')

@section('content')

@if(session('debug_stats'))
<div class="alert alert-danger">
    <h5>DEBUG STATS:</h5>
    <p>User ID: {{ session('debug_user_id') }}</p>
    <pre>{{ print_r(session('debug_stats'), true) }}</pre>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <h1>Profil użytkownika: {{ session('user_login') }}</h1>
        
        <div class="row mt-4">
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Do przeczytania</h5>
                        <h3>{{ $stats['want_to_read'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Czytam</h5>
                        <h3>{{ $stats['reading_now'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Przeczytane</h5>
                        <h3>{{ $stats['completed'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Porzucone</h5>
                        <h3>{{ $stats['abandoned'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Średnia ocena</h5>
                        <h3>{{ $stats['average_rating'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Recenzje</h5>
                        <h3>{{ $user->reviews->count() ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Moje książki ({{ $user->trackedBooks->count() }})</h4>
                        
                        @if($user->trackedBooks->count() > 0)
                            <div class="list-group">
                                @foreach($user->trackedBooks->take(5) as $book)
                                    <a href="/books/{{ $book->id_book }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $book->title }}</h6>
                                            <small>
                                                <span class="badge bg-{{ 
                                                    $book->pivot->id_status == 3 ? 'success' : 
                                                    ($book->pivot->id_status == 2 ? 'warning' : 'secondary')
                                                }}">
                                                    @if($book->pivot->id_status == 1)
                                                        Do przeczytania
                                                    @elseif($book->pivot->id_status == 2)
                                                        Czytam
                                                    @elseif($book->pivot->id_status == 3)
                                                        Przeczytane
                                                    @elseif($book->pivot->id_status == 4)
                                                        Porzucone
                                                    @else
                                                        Brak statusu
                                                    @endif
                                                </span>
                                            </small>
                                        </div>
                                        <small class="text-muted">{{ $book->author }}</small>
                                    </a>
                                @endforeach
                            </div>
                            
                            @if($user->trackedBooks->count() > 5)
                                <div class="mt-3">
                                    <a href="/mybooks" class="btn btn-sm btn-outline-primary">
                                        Zobacz wszystkie książki ({{ $user->trackedBooks->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <p class="text-muted">Nie masz jeszcze książek w swojej liście.</p>
                            <a href="/books" class="btn btn-primary">Przeglądaj książki</a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Moje recenzje ({{ $user->reviews->count() }})</h4>
                        
                        @if($user->reviews->count() > 0)
                            <div class="list-group">
                                @foreach($user->reviews->take(5) as $review)
                                    <a href="/books/{{ $review->book->id_book }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $review->book->title }}</h6>
                                            <small>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        ⭐
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </small>
                                        </div>
                                        <p class="mb-1">{{ Str::limit($review->content, 100) }}</p>
                                        <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Nie napisałeś jeszcze żadnej recenzji.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Informacje o koncie</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Login:</strong> {{ $user->login }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p>
                                    <strong>Moje książki:</strong> 
                                    <a href="/mybooks" class="text-decoration-none">
                                        {{ $user->trackedBooks->count() }} książek w liście
                                    </a>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Data rejestracji:</strong> {{ $user->created_at->format('d.m.Y') }}</p>
                                <p><strong>Role:</strong> {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</p>
                            </div>
                            <div class="col-md-4">
                                @if(in_array('Admin', $user->roles->pluck('name')->toArray()) || in_array('Moderator', $user->roles->pluck('name')->toArray()))
                                    <p>
                                        <strong>Dodane książki:</strong> 
                                        <a href="/books" class="text-decoration-none">
                                            {{ $user->booksAdded->count() }}
                                        </a>
                                        (jako moderator/admin)
                                    </p>
                                    <p>
                                        <strong>Edytowane książki:</strong> 
                                        <a href="/books" class="text-decoration-none">
                                            {{ $user->booksUpdated->count() }}
                                        </a>
                                        (jako moderator/admin)
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection