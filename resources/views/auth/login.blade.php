@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Logowanie</div>
            <div class="card-body">
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">
                        <label>Login</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Hasło</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Zaloguj</button>
                </form>
                <div class="mt-3">
                    <a href="/register">Nie masz konta? Zarejestruj się</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection