<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookTracker @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-brown: #3C2F2F;
            --medium-brown: #4A3728;
            --light-brown: #5D4037;
            --wood-brown: #6D4C41;
            --parchment: #F5E6CA;
            --gold: #D4AF37;
            --bronze: #CD7F32;
            --rust: #B7410E;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #FAF3E0; /* LEKKO BEŻOWE TŁO CAŁEJ STRONY */
            color: #3C2F2F; /* CIEMNY BRĄZ NA TEKST */
            font-family: 'Georgia', serif;
        }
        
        main {
            flex: 1;
        }
        
        .navbar {
            background: linear-gradient(to right, var(--dark-brown), var(--medium-brown));
            border-bottom: 3px solid var(--bronze);
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
            padding: 15px 0;
        }
        
        .navbar-brand {
            color: var(--gold) !important;
            font-family: 'Georgia', serif;
            font-size: 1.8rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .navbar-brand:hover {
            color: #FFD700 !important;
        }
        
        .nav-link {
            color: var(--parchment) !important;
            font-weight: 500;
            margin: 0 10px;
            padding: 8px 15px !important;
            border-radius: 4px;
            transition: all 0.3s;
            border: 1px solid transparent;
        }
        
        .nav-link:hover {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid var(--bronze);
            color: var(--gold) !important;
        }
        
        .btn-primary {
            background: linear-gradient(to bottom, var(--bronze), var(--rust));
            border: 2px solid var(--gold);
            color: var(--parchment);
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to bottom, var(--rust), var(--bronze));
            border-color: #FFD700;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }
        
        .btn-outline-warning {
            border-color: var(--gold);
            color: var(--gold);
        }
        
        .btn-outline-warning:hover {
            background-color: var(--gold);
            color: var(--dark-brown);
        }
        
        .book-card {
            background: linear-gradient(to bottom right, #FFFBF0, #F8F4E9);
            border: 2px solid var(--wood-brown);
            border-radius: 12px;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s;
            color: #3C2F2F; /* CIEMNY BRĄZ NA TEKST */
            overflow: hidden;
            position: relative;
        }
        
        .book-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, var(--gold), var(--bronze), var(--gold));
        }
        
        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 8px 12px 25px rgba(0,0,0,0.4);
            border-color: var(--gold);
        }
        
        /* TEKST W KARTACH - CIEMNIEJSZY */
        .card-title {
            color: #2C1810 !important; /* BARDZO CIEMNY BRĄZ */
            font-weight: bold;
        }
        
        .card-subtitle {
            color: #5D4037 !important; /* ŚREDNI BRĄZ */
            font-weight: 500;
        }
        
        .card-text {
            color: #4A3728 !important; /* CIEMNY BRĄZ */
        }
        
        .alert-success {
            background: linear-gradient(to right, rgba(46, 125, 50, 0.9), rgba(56, 142, 60, 0.9));
            border: 2px solid #388E3C;
            color: var(--parchment);
            border-radius: 8px;
            border-left: 8px solid #4CAF50;
        }
        
        .alert-danger {
            background: linear-gradient(to right, rgba(183, 28, 28, 0.9), rgba(198, 40, 40, 0.9));
            border: 2px solid #C62828;
            color: var(--parchment);
            border-radius: 8px;
            border-left: 8px solid #F44336;
        }
        
        .alert-warning {
            background: linear-gradient(to right, rgba(245, 158, 11, 0.9), rgba(251, 191, 36, 0.9));
            border: 2px solid var(--bronze);
            color: var(--dark-brown);
            border-radius: 8px;
            border-left: 8px solid var(--gold);
        }
        
        .form-control, .form-select {
            background-color: rgba(245, 230, 202, 0.9);
            border: 2px solid var(--wood-brown);
            color: var(--dark-brown);
            border-radius: 6px;
            font-family: 'Georgia', serif;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: var(--parchment);
            border-color: var(--gold);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
            color: var(--dark-brown);
        }
        
        h1, h2, h3 {
            color: var(--gold);
            font-family: 'Georgia', serif;
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        h1::after, h2::after, h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, transparent, var(--gold), transparent);
        }
        
        footer {
            background: linear-gradient(to right, var(--dark-brown), var(--medium-brown));
            border-top: 3px solid var(--bronze);
            margin-top: auto;
            padding: 25px 0;
            text-align: center;
            color: var(--parchment);
        }
        
        .badge {
            font-family: 'Georgia', serif;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: normal;
        }
        
        .bg-warning {
            background: linear-gradient(to right, var(--bronze), var(--rust)) !important;
            color: var(--parchment) !important;
        }
        
        .bg-success {
            background: linear-gradient(to right, #2E7D32, #388E3C) !important;
        }
        
        .pagination .page-link {
            background-color: var(--medium-brown);
            border-color: var(--wood-brown);
            color: var(--parchment);
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(to bottom, var(--bronze), var(--rust));
            border-color: var(--gold);
        }
        
        .container {
            max-width: 1200px;
        }
        
        /* DODATKOWE: Linki w tekście */
        a {
            color: var(--rust);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        a:hover {
            color: var(--gold);
            text-decoration: underline;
        }
        
        /* Tekst pomocniczy */
        .text-muted {
            color: #8D6E63 !important; /* JAŚNIEJSZY BRĄZ */
        }
        
        .lead {
            color: #5D4037; /* ŚREDNI BRĄZ */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                📚 BookTracker
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            Strona główna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/books">
                            Wszystkie książki
                        </a>
                    </li>
                    
                    @if(session('user_id'))
                        <li class="nav-item">
                            <a class="nav-link" href="/profile">
                                Mój profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="/logout" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">
                                    Wyloguj się
                                </button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">
                                Witaj, <strong>{{ session('user_login') }}</strong>
                            </span>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                Zaloguj się
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">
                                Zarejestruj się
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p class="mb-2">BookTracker &copy; {{ date('Y') }}</p>
            <small class="text-muted">System śledzenia i recenzowania książek</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>