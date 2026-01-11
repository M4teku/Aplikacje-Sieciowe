@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>{{ $book->title }}</h1>
        <p class="lead">{{ $book->author }}</p>
        <p><strong>Gatunek:</strong> {{ $book->genre }}</p>
        <p>{{ $book->description }}</p>
        
        <div class="mt-4">
            <a href="/books" class="btn btn-secondary">← Powrót do listy</a>
            @if(session('user_id'))
                <button class="btn btn-success">Dodaj do mojej listy</button>
            @endif
        </div>
    </div>
</div>
@endsection