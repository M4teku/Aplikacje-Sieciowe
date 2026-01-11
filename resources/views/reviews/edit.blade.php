@extends('layouts.app')

@section('title', 'Edytuj recenzję - BookTracker')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h2>Edytuj recenzję</h2>
                <p class="lead">Książka: {{ $review->book->title }}</p>
                
                <form action="{{ route('reviews.update', $review->id_review) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label">Twoja ocena (1-5 gwiazdek)</label>
                        <div class="d-flex gap-2 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" 
                                           id="rating{{ $i }}" value="{{ $i }}" 
                                           {{ $review->rating == $i ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="rating{{ $i }}">
                                        @for($j = 1; $j <= $i; $j++)⭐@endfor
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Treść recenzji</label>
                        <textarea name="content" class="form-control" rows="8" required>{{ $review->content }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.show', $review->book->id_book) }}" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection