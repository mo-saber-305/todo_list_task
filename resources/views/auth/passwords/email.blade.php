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
            <h2>Reset Password</h2>
            <p>Enter your email to receive a reset link</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span class="small fw-medium">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="form-label small fw-semibold text-dark">Email Address</label>
                <div class="auth-input-group">
                    <i class="bi bi-envelope"></i>
                    <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary-custom w-100 py-2 d-flex justify-content-center align-items-center gap-2">
                <i class="bi bi-send"></i>
                <span>Send Reset Link</span>
            </button>

            <!-- Back to Login -->
            <div class="text-center mt-4 pt-2 border-top">
                <p class="small text-muted mb-0">
                    Remembered your password? 
                    <a href="{{ route('login') }}" class="auth-link fw-semibold">
                        Back to sign in
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
