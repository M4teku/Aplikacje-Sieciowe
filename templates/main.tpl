<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$page_title|default:"Kalkulator"}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #764ba2; /* Fiolet bez gradientu */
            min-height: 100vh;
        }
        .calculator-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }
        .result-box {
            background: #d4edda;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }
        .error-box {
            background: #f8d7da;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }
        .nav-custom {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <!-- STARY HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{$app_url}/app/calc.php">
                <i class="fas fa-calculator me-2"></i>Kalkulatory
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link {if $current_page == 'simple'}active{/if}" href="{$app_url}/app/calc.php">
                    <i class="fas fa-calculator me-1"></i>Prosty
                </a>
                <a class="nav-link {if $current_page == 'credit'}active{/if}" href="{$app_url}/app/credit_calc.php">
                    <i class="fas fa-home me-1"></i>Kredytowy
                </a>
                <a class="nav-link" href="{$app_url}/app/security/logout.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Wyloguj ({$user|default:"Gość"})
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="calculator-card">
                    <h2 class="text-center mb-4 text-primary">
                        <i class="fas fa-calculator me-2"></i>{$page_title|default:"Kalkulator"}
                    </h2>
                    {if isset($page_description)}
                    <p class="text-center text-muted">{$page_description}</p>
                    {/if}

                    {block name=content}{/block}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>