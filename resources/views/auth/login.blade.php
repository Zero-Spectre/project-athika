<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .login-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .login-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
        }
        
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            color: white;
        }
        
        .social-btn {
            border-radius: 10px;
            padding: 10px;
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .text-primary {
            color: #4CAF50 !important;
        }
        
        .btn-outline-primary {
            color: #4CAF50;
            border-color: #4CAF50;
        }
        
        .btn-outline-primary:hover {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="row g-0 login-card">
                    <div class="col-md-6 d-none d-md-block p-0">
                        <div class="h-100 bg-white d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1536104968055-4d61aa56f46a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80" class="img-fluid" alt="Learning">
                        </div>
                    </div>
                    <div class="col-md-6 bg-white">
                        <div class="p-5">
                            <div class="text-center mb-5">
                                <h1 class="h3 text-primary login-brand">
                                    <i class="fas fa-leaf me-2"></i>{{ config('app.name') }}
                                </h1>
                                <h2 class="h5 mt-4">Welcome Back!</h2>
                                <p class="text-muted">Sign in to continue your learning journey</p>
                            </div>
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('login') }}">
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
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter your password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-login">Sign In</button>
                                </div>
                            </form>
                            
                            <div class="text-center mb-4">
                                <p class="text-muted mb-0">Or continue with</p>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <a href="#" class="btn btn-outline-primary social-btn flex-fill">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary social-btn flex-fill">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary social-btn flex-fill">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                            
                            <div class="text-center">
                                <p>Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Sign up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome for icons -->
    <script src="{{ asset('vendor/fontawesome/js/all.min.js') }}"></script>
</body>
</html>