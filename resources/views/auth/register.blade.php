<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name') }}</title>
    
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
        
        .register-card {
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .register-brand {
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
        
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
        }
        
        .form-select:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-register:hover {
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
            <div class="col-md-12 col-lg-10">
                <div class="row g-0 register-card">
                    <div class="col-md-6 bg-white">
                        <div class="p-5 h-100 d-flex flex-column">
                            <div class="text-center mb-4">
                                <h1 class="h3 text-primary register-brand">
                                    <i class="fas fa-leaf me-2"></i>{{ config('app.name') }}
                                </h1>
                                <h2 class="h5 mt-4">Create Account</h2>
                                <p class="text-muted">Join our learning community today</p>
                            </div>
                            
                            <form method="POST" action="{{ route('register') }}" class="flex-grow-1">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label for="name" class="form-label fw-bold">Full Name</label>
                                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-12 mb-4">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label fw-bold">Password</label>
                                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Create a password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                                        <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required placeholder="Confirm your password">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="peran" class="form-label fw-bold">Role</label>
                                    <select class="form-select form-select-lg @error('peran') is-invalid @enderror" id="peran" name="peran" required>
                                        <option value="">Select your role</option>
                                        <option value="Peserta" {{ old('peran') == 'Peserta' ? 'selected' : '' }}>Student</option>
                                        <option value="Instruktur" {{ old('peran') == 'Instruktur' ? 'selected' : '' }}>Instructor</option>
                                    </select>
                                    @error('peran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-register">Create Account</button>
                                </div>
                            </form>
                            
                            <div class="text-center mt-auto">
                                <p>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-block p-0">
                        <div class="h-100 bg-white d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=600&q=80" class="img-fluid" alt="Learning">
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