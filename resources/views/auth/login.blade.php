@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="auth-card">
        <div class="auth-header">
            <a href="{{ url('/') }}" class="auth-brand-link" title="Back to Home">
                <div class="brand-icon-box">
                    <i class="bi bi-check2-square"></i>
                </div>
                <span class="auth-brand-name">{{ config('app.name', 'Todo List') }}</span>
            </a>
            <h2>Welcome Back</h2>
            <p>Enter your credentials to access your tasks</p>
        </div>

        <!-- Demo Credentials Helper -->
        <div class="demo-credentials-badge">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-key-fill text-primary"></i>
                <div>
                    <span class="fw-semibold text-dark">Demo:</span> mosaber@test.com
                </div>
            </div>
            <span class="badge bg-light text-muted border">Pass: 12345678</span>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold text-dark">Email Address</label>
                <div class="auth-input-group">
                    <i class="bi bi-envelope"></i>
                    <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'mosaber@test.com') }}" placeholder="name@example.com" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label small fw-semibold text-dark mb-0">Password</label>
                    @if (Route::has('password.request'))
                        <a class="auth-link small fw-semibold" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <div class="auth-input-group">
                    <i class="bi bi-lock"></i>
                    <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" value="12345678" placeholder="••••••••" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                    <label class="form-check-label small text-muted fw-medium" for="remember">
                        Remember this device
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary-custom w-100 py-2 d-flex justify-content-center align-items-center gap-2">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign In</span>
            </button>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="text-center mt-4 pt-2 border-top">
                    <p class="small text-muted mb-0">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="auth-link fw-semibold">
                            Create an account
                        </a>
                    </p>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
