@extends('layouts.app')

@section('title', 'Login to Your Account | CEUTrainers')

@section('styles')
<style>
    .auth-page {
        background:
            linear-gradient(135deg, rgba(26, 182, 157, 0.08), rgba(238, 74, 127, 0.06) 52%, rgba(255, 255, 255, 0.95)),
            #fff;
        overflow: hidden;
        padding: 70px 0;
        position: relative;
    }

    .auth-page::before {
        background-image: radial-gradient(#1ab69d 2px, transparent 2px);
        background-size: 20px 20px;
        content: "";
        height: 150px;
        left: 8%;
        opacity: 0.35;
        position: absolute;
        top: 70px;
        width: 190px;
    }

    .auth-shell {
        background: #fff;
        border: 1px solid rgba(17, 24, 39, 0.08);
        border-radius: 8px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
        margin: 0 auto;
        max-width: 620px;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .auth-card {
        background: #fff;
        padding: 50px 54px;
    }

    .auth-icon {
        align-items: center;
        background: rgba(26, 182, 157, 0.1);
        border-radius: 50%;
        color: #1ab69d;
        display: inline-flex;
        font-size: 26px;
        height: 64px;
        justify-content: center;
        margin-bottom: 18px;
        width: 64px;
    }

    .auth-card h2 {
        color: #171717;
        font-family: var(--font-heading);
        font-size: 38px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .auth-card .auth-subtitle {
        color: #63666d;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .auth-form-label {
        color: #171717;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .auth-input {
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        display: flex;
        min-height: 56px;
        padding: 0 18px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .auth-input:focus-within {
        background: #fff;
        border-color: #1ab69d;
        box-shadow: 0 0 0 4px rgba(26, 182, 157, 0.12);
    }

    .auth-input i {
        color: #8a8f98;
        flex: 0 0 auto;
        margin-right: 12px;
    }

    .auth-input .form-control {
        background: transparent;
        border: 0;
        box-shadow: none;
        color: #171717;
        font-size: 16px;
        height: 54px;
        padding: 0;
    }

    .auth-input .form-control::placeholder {
        color: #9ca3af;
    }

    .auth-input .form-control.is-invalid {
        padding-right: 0;
    }

    .auth-row {
        align-items: center;
        display: flex;
        gap: 14px;
        justify-content: space-between;
        margin: 18px 0 28px;
    }

    .auth-row .form-check {
        align-items: center;
        display: flex;
        gap: 10px;
        margin: 0;
        min-height: auto;
        padding-left: 0;
    }

    .auth-row .form-check-input {
        border-color: #cfd4dc;
        height: 18px;
        margin: 0;
        width: 18px;
    }

    .auth-row .form-check-input:checked {
        background-color: #1ab69d;
        border-color: #1ab69d;
    }

    .auth-row label,
    .auth-row a {
        font-size: 14px;
    }

    .auth-row a,
    .auth-footer a {
        color: #1ab69d;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-submit {
        align-items: center;
        background: #1ab69d;
        border: 0;
        border-radius: 6px;
        color: #fff;
        display: inline-flex;
        font-size: 16px;
        font-weight: 700;
        gap: 8px;
        justify-content: center;
        min-height: 56px;
        width: 100%;
    }

    .auth-submit:hover {
        background: #159e88;
        color: #fff;
    }

    .auth-footer {
        color: #63666d;
        font-size: 15px;
        margin: 24px 0 0;
        text-align: center;
    }

    @media (max-width: 575px) {
        .auth-page {
            padding: 36px 0;
        }

        .auth-card {
            padding: 34px 22px;
        }

        .auth-card h2 {
            font-size: 30px;
        }

        .auth-row {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }
    }
</style>
@endsection

@section('content')

<div class="auth-page">
    <div class="container">
        <div class="auth-shell">
            <div class="auth-card">
                <div class="text-center">
                    <span class="auth-icon"><i class="fa fa-user-o"></i></span>
                    <h2>Welcome Back</h2>
                    <p class="auth-subtitle">Sign in to resume claiming CEUs and managing your courses.</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="auth-form-label">Email Address</label>
                        <div class="auth-input">
                            <i class="fa fa-envelope-o"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@company.com" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="auth-form-label">Password</label>
                        <div class="auth-input">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter your password" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-row">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label text-slate" for="remember">Remember my session</label>
                        </div>
                        <a href="#" onclick="event.preventDefault(); alert('Password reset placeholder. Please contact site support.')">Forgot Password?</a>
                    </div>

                    <button type="submit" class="auth-submit" id="auth-login-submit-btn">
                        Sign In <i class="fa fa-sign-in"></i>
                    </button>

                    <p class="auth-footer">
                        New to CEUTrainers? <a href="{{ route('register') }}">Create a free account</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
