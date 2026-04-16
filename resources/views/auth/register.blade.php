@extends('layouts.app')

@section('title', 'Register - TripMalwana')

@section('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 130px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0f4c2a 0%, #1a6b3a 100%);
        padding: 40px 20px;
    }
    .auth-card {
        background: #fff;
        border-radius: 20px;
        padding: 50px 40px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .auth-card h2 {
        font-family: 'Playfair Display', serif;
        color: #1a6b3a;
    }
    .form-control:focus {
        border-color: #1a6b3a;
        box-shadow: 0 0 0 0.2rem rgba(26,107,58,0.15);
    }
    .btn-register {
        background: #f0a500;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s;
    }
    .btn-register:hover {
        background: #d4920a;
        color: #fff;
        transform: translateY(-2px);
    }
    .divider {
        text-align: center;
        color: #aaa;
        margin: 20px 0;
        position: relative;
    }
    .divider::before, .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 42%;
        height: 1px;
        background: #eee;
    }
    .divider::before { left: 0; }
    .divider::after { right: 0; }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="text-center mb-4">
            <i class="fas fa-user-plus fa-2x" style="color:#1a6b3a"></i>
        </div>
        <h2 class="text-center">Create Account</h2>
        <p class="text-center text-muted mb-4">Join TripMalwana and start planning</p>

        @if($errors->any())
            <div class="alert alert-danger rounded-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name" class="form-control form-control-lg rounded-3"
                       value="{{ old('name') }}" placeholder="John Doe" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control form-control-lg rounded-3"
                       value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control form-control-lg rounded-3"
                       placeholder="Min. 6 characters" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-lg rounded-3"
                       placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus me-2"></i> Create Account
            </button>
        </form>

        <div class="divider">or</div>

        <div class="text-center">
            <p class="text-muted mb-0">Already have an account?
                <a href="{{ route('login') }}" style="color:#1a6b3a; font-weight:600;">Sign in here</a>
            </p>
        </div>
    </div>
</div>
@endsection