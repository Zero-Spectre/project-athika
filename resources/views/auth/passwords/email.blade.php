<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Sawit Learning</title>
    
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
        
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
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
        
        .btn-primary {
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .text-primary {
            color: #4CAF50 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 text-primary">
                                <i class="fas fa-leaf"></i> Sawit
                            </h1>
                            <h2 class="h5 mb-3">Reset your password</h2>
                            <p class="text-muted">Enter your email address and we'll send you a link to reset your password.</p>
                        </div>
                        
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">Back to login</a>
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