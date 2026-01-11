<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookTracker - System śledzenia książek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .hero-section {
            padding-top: 100px;
            padding-bottom: 100px;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-booktracker {
            background: white;
            color: #764ba2;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-booktracker:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Nawigacja -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">📚 BookTracker</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/books">Przeglądaj książki</a>
                @if(session('user_id'))
                    <a class="nav-link" href="/profile">Mój profil</a>
                    <form method="POST" action="/logout" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Wyloguj</button>
                    </form>
                @else
                    <a class="nav-link" href="/login">Zaloguj</a>
                    <a class="nav-link" href="/register">Rejestracja</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Główna sekcja -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4">📖 BookTracker</h1>
            <p class="lead mb-5">Twój osobisty system śledzenia czytania.<br>Dodawaj książki, śledź postęp, oceniaj i recenzuj!</p>
            
            <div class="row justify-content-center mb-5">
                <div class="col-md-4">
                    <div class="feature-card">
                        <h4>👤 Profil</h4>
                        <p>Śledź swoje statystyki czytania i ulubione gatunki</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <h4>📚 Lista książek</h4>
                        <p>4 statusy: Do przeczytania, Czytam, Przeczytane, Porzucone</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <h4>⭐ Recenzje</h4>
                        <p>Oceniaj książki w skali 1-5 i pisz recenzje</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="/books" class="btn btn-booktracker me-3">Przeglądaj książki</a>
                
                @if(!session('user_id'))
                    <a href="/login" class="btn btn-outline-light me-3">Zaloguj się</a>
                    <a href="/register" class="btn btn-outline-light">Zarejestruj się</a>
                @else
                    <a href="/profile" class="btn btn-booktracker">
                        👤 Witaj, {{ session('user_login') }}
                    </a>
                @endif
            </div>
            
            <!-- Testowe dane -->
            <div class="mt-5 text-muted">
                <small>
                    Dane testowe:<br>
                    <strong>Admin:</strong> login: admin, hasło: admin123<br>
                    <strong>Użytkownik:</strong> zarejestruj nowe konto
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>