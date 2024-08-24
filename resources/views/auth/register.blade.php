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
            <h2>Create an Account</h2>
            <p>Start organizing your tasks in seconds</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Input -->
            <div class="mb-3">
                <label for="name" class="form-label small fw-semibold text-dark">Full Name</label>
                <div class="auth-input-group">
                    <i class="bi bi-person"></i>
                    <input id="name" type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Mohamed Saber" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold text-dark">Email Address</label>
                <div class="auth-input-group">
                    <i class="bi bi-envelope"></i>
                    <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold text-dark">Password</label>
                <div class="auth-input-group">
                    <i class="bi bi-lock"></i>
                    <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-4">
                <label for="password-confirm" class="form-label small fw-semibold text-dark">Confirm Password</label>
                <div class="auth-input-group">
                    <i class="bi bi-shield-lock"></i>
                    <input id="password-confirm" type="password" class="form-control form-control-custom" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary-custom w-100 py-2 d-flex justify-content-center align-items-center gap-2">
                <i class="bi bi-person-check"></i>
                <span>Register</span>
            </button>

            <!-- Login Link -->
            <div class="text-center mt-4 pt-2 border-top">
                <p class="small text-muted mb-0">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="auth-link fw-semibold">
                        Sign in instead
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
