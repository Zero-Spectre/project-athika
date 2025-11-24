<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - {{ config('app.name') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .reset-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .reset-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
        }
        
        .form-control:focus {
            border-color: #a1c4fd;
            box-shadow: 0 0 0 0.25rem rgba(161, 196, 253, 0.25);
        }
        
        .btn-reset {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card reset-card border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h1 class="h3 text-primary reset-brand">
                                <i class="fas fa-graduation-cap me-2"></i>{{ config('app.name') }}
                            </h1>
                            <h2 class="h5 mt-4">Reset Your Password</h2>
                            <p class="text-muted">Enter your email address and we'll send you a link to reset your password.</p>
                        </div>
                        
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-reset">Send Reset Link</button>
                            </div>
                        </form>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                <i class="fas fa-arrow-left me-2"></i>Back to login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome for icons -->
    <script src="{{ asset('vendor/fontawesome/js/all.min.js') }}"></script>