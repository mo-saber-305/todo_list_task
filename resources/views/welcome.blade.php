<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Todo List') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center p-3">

    <div class="minimal-card">
        <div class="brand-icon-box brand-icon-box-lg">
            <i class="bi bi-check2-square"></i>
        </div>

        <h1 class="app-title">{{ config('app.name', 'Todo List') }}</h1>
        <p class="app-subtitle">A clean, lightweight task manager to keep your daily work organized and focused.</p>

        <div class="auth-actions">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn-primary-simple">
                        <i class="bi bi-arrow-right-circle"></i>
                        <span>Go to Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary-simple">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Log in</span>
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary-simple">
                            <i class="bi bi-person-plus"></i>
                            <span>Create an Account</span>
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

</body>
</html>
