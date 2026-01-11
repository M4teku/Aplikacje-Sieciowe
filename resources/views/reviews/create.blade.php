@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h2>Dodaj recenzję: {{ $book->title }}</h2>
                <p class="lead">Autor: {{ $book->author }}</p>
                
                <form action="{{ route('reviews.store', $book->id_book) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label">Twoja ocena (1-5 gwiazdek)</label>
                        <div class="d-flex gap-2 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                                    <label class="form-check-label" for="rating{{ $i }}">
                                        @for($j = 1; $j <= $i; $j++)⭐@endfor
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Treść recenzji</label>
                        <textarea name="content" class="form-control" rows="8" placeholder="Napisz swoją recenzję..." required></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.show', $book->id_book) }}" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">Dodaj recenzję</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection