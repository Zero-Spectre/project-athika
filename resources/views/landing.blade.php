<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Palm Oil Learning Platform</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        
        .feature-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: all 0.3s ease;
        }
        
        .course-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .course-img {
            height: 200px;
            object-fit: cover;
        }
        
        .testimonial-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .cta-section {
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxjaXJjbGUgY3g9IjIwIiBjeT0iMjAiIHI9IjAuNSIgZmlsbD0iI2ZmZiIgZmlsbC1vcGFjaXR5PSIwLjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiLz48L3N2Zz4=');
        }
        
        .footer-link {
            text-decoration: none;
            color: #adb5bd;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: #fff;
            transform: translateX(5px);
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-5px);
            background-color: #fff !important;
            color: #000 !important;
        }
        
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .navbar-scrolled .navbar-brand,
        .navbar-scrolled .nav-link {
            color: #333 !important;
        }
        
        .btn-rounded {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-rounded:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Palm Oil Theme Specific Styles */
        .palm-leaf {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
        }
        
        .palm-icon {
            color: #8BC34A;
        }
        
        .palm-accent {
            color: #4CAF50;
        }
        
        .palm-bg {
            background-color: #E8F5E9;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
                <i class="fas fa-seedling me-2"></i>{{ config('app.name') }}
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-5">
                    <li class="nav-item mx-2">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#courses">Courses</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light btn-rounded px-4" href="{{ route('redirectBasedOnRole') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success btn-rounded px-4 fw-bold" href="{{ route('diskusi.index') }}">Diskusi</a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light btn-rounded px-4" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success btn-rounded px-4 fw-bold" href="{{ route('register') }}">Get Started</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white py-5">
        <div class="container py-5 mt-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-3 fw-bold mb-4">Master Palm Oil Industry Knowledge</h1>
                    <p class="lead fs-5 mb-4">Join our specialized platform and gain expertise in palm oil cultivation, processing, sustainability, and industry best practices. Empower your career in the palm oil sector.</p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('redirectBasedOnRole') }}" class="btn btn-success btn-lg btn-rounded px-5 fw-bold">Dashboard</a>
                            <a href="{{ route('diskusi.index') }}" class="btn btn-outline-light btn-lg btn-rounded px-5">Diskusi</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-success btn-lg btn-rounded px-5 fw-bold">Get Started</a>
                            <a href="#features" class="btn btn-outline-light btn-lg btn-rounded px-5">Learn More</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <div class="bg-white rounded-4 shadow-lg p-4" style="transform: rotate(5deg);">
                            <img src="https://images.unsplash.com/photo-1605792657660-596af9009e19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=400&q=80" class="img-fluid rounded-3" alt="Palm Oil Plantation">
                        </div>
                        <div class="bg-white rounded-4 shadow-lg p-4 position-absolute top-50 start-50 translate-middle" style="transform: rotate(-10deg); width: 80%; z-index: -1;">
                            <img src="https://images.unsplash.com/photo-1597564189065-625ef3a1f0d2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=400&q=80" class="img-fluid rounded-3" alt="Palm Oil Processing">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <h2 class="display-5 fw-bold palm-accent">5K+</h2>
                    <p class="text-muted">Industry Professionals</p>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <h2 class="display-5 fw-bold palm-accent">200+</h2>
                    <p class="text-muted">Expert Instructors</p>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <h2 class="display-5 fw-bold palm-accent">50+</h2>
                    <p class="text-muted">Specialized Courses</p>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <h2 class="display-5 fw-bold palm-accent">95%</h2>
                    <p class="text-muted">Job Placement Rate</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 palm-bg">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Palm Oil Industry Expertise</h2>
                <p class="lead text-muted">Discover what makes our palm oil learning platform exceptional</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center border-0">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-4">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h5 class="card-title fw-bold">Cultivation Techniques</h5>
                            <p class="card-text text-muted">Learn advanced palm oil cultivation methods, soil management, and sustainable farming practices.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center border-0">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-4">
                                <i class="fas fa-industry"></i>
                            </div>
                            <h5 class="card-title fw-bold">Processing Technology</h5>
                            <p class="card-text text-muted">Master modern palm oil processing techniques and mill operations from industry experts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center border-0">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-4">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h5 class="card-title fw-bold">Industry Certification</h5>
                            <p class="card-text text-muted">Earn recognized certifications to showcase your palm oil expertise to employers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center border-0">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-4">
                                <i class="fas fa-globe-asia"></i>
                            </div>
                            <h5 class="card-title fw-bold">Sustainability Focus</h5>
                            <p class="card-text text-muted">Learn about RSPO standards, environmental conservation, and sustainable practices.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center border-0">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-4">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="card-title fw-bold">Market Analysis</h5>
                            <p class="card-text text-muted">Understand global palm oil markets, pricing trends, and trade regulations.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center border-0">
                        <div class="card-body p-4">
                            <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-4">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title fw-bold">Industry Network</h5>
                            <p class="card-text text-muted">Connect with other professionals and access exclusive industry opportunities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
  

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Industry Professional Testimonials</h2>
                <p class="lead text-muted">Hear from our satisfied learners in the palm oil industry</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 border-0">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" alt="User" width="60" height="60">
                                <div>
                                    <h5 class="mb-0">Ahmad Saputra</h5>
                                    <p class="text-muted mb-0">Plantation Manager</p>
                                </div>
                            </div>
                            <p class="card-text">"The cultivation course transformed my approach to palm oil farming. Our yield increased by 25% after implementing the techniques learned here!"</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 border-0">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle me-3" alt="User" width="60" height="60">
                                <div>
                                    <h5 class="mb-0">Siti Nurhaliza</h5>
                                    <p class="text-muted mb-0">Processing Engineer</p>
                                </div>
                            </div>
                            <p class="card-text">"The processing technology course was comprehensive and practical. I was able to optimize our mill operations and reduce waste significantly."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 border-0">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/men/68.jpg" class="rounded-circle me-3" alt="User" width="60" height="60">
                                <div>
                                    <h5 class="mb-0">Budi Santoso</h5>
                                    <p class="text-muted mb-0">Sustainability Coordinator</p>
                                </div>
                            </div>
                            <p class="card-text">"The RSPO certification course was exactly what I needed. We successfully achieved certification for our entire operation within a year."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-dark py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold">Ready to Advance Your Palm Oil Career?</h2>
                    <p class="lead">Join thousands of industry professionals and start your learning journey today. Transform your expertise with our specialized courses.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-dark btn-lg btn-rounded px-5 fw-bold">Get Started Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="about" class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 fw-bold">{{ config('app.name') }}</h5>
                    <p class="text-muted">Empowering palm oil industry professionals with specialized knowledge and skills. Transform your career with our expert-led courses.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon bg-success text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon bg-success text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon bg-success text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon bg-success text-white me-2"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 fw-bold">Explore</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Home</a></li>
                        <li class="mb-2"><a href="#features" class="footer-link">Features</a></li>
                        <li class="mb-2"><a href="#courses" class="footer-link">Courses</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Blog</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 fw-bold">Resources</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="footer-link">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Partners</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Careers</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Terms</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 fw-bold">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@{{ strtolower(str_replace(' ', '', config('app.name'))) }}.com</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +62 (21) 1234-5678</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Palm Oil Education Center, Jakarta</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <p class="mb-0 text-muted">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="input-group">
                        <input type="email" class="form-control rounded-start-pill" placeholder="Your Email">
                        <button class="btn btn-outline-light rounded-end-pill" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    </script>
</body>
</html>