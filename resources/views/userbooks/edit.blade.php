@extends('layouts.app')

@section('title', 'Edytuj książkę w liście - BookTracker')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Edytuj książkę w liście</h2>
                
                <div class="mb-4">
                    <h4>{{ $userBook->book->title }}</h4>
                    <p class="lead">{{ $userBook->book->author }}</p>
                </div>
                
                <form action="{{ route('userbooks.update', $userBook->book->id_book) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Status czytania</label>
                        <select name="id_status" class="form-select" required>
                            <option value="">Wybierz status...</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id_status }}" 
                                        {{ $userBook->id_status == $status->id_status ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/mybooks" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection