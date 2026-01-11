@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Rejestracja</div>
            <div class="card-body">
                <form method="POST" action="/register">
                    @csrf
                    <div class="mb-3">
                        <label>Login</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Hasło</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Potwierdź hasło</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Zarejestruj</button>
                </form>
                <div class="mt-3">
                    <a href="/login">Masz już konto? Zaloguj się</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection