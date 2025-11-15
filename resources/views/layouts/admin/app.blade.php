<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard - ' . config('app.name'))</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .admin-navbar {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 1rem 0;
        }
        
        .admin-navbar .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .admin-navbar .nav-link {
            font-weight: 500;
            margin: 0 5px;
            padding: 10px 15px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .admin-navbar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .admin-navbar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler {
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .sidebar {
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            min-height: calc(100vh - 56px);
            position: sticky;
            top: 56px;
        }
        
        .sidebar .nav-link {
            color: #495057;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: #fff;
        }
        
        .main-content {
            min-height: calc(100vh - 56px);
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            border-left: 4px solid;
        }
        
        .stat-card-primary {
            border-left-color: #28a745;
        }
        
        .stat-card-success {
            border-left-color: #28a745;
        }
        
        .stat-card-warning {
            border-left-color: #ffc107;
        }
        
        .stat-card-danger {
            border-left-color: #dc3545;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #208030 0%, #28a745 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .table th {
            font-weight: 600;
        }
        
        .badge-status {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%) !important;
        }
        
        .bg-gradient-instructor {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%) !important;
        }
        
        .bg-gradient-participant {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%) !important;
        }
        
        .rounded-4 {
            border-radius: 20px !important;
        }
        
        .opacity-75 {
            opacity: 0.75;
        }
        
        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .user-avatar-lg {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: white !important;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
        }
        
        .greeting-text {
            font-weight: 500;
            margin-right: 5px;
        }
        
        /* Additional colors for dashboard */
        .bg-purple {
            background-color: #6f42c1 !important;
        }
        
        .text-purple {
            color: #6f42c1 !important;
        }
        
        .bg-teal {
            background-color: #20c997 !important;
        }
        
        .text-teal {
            color: #20c997 !important;
        }
        
        .bg-info {
            background-color: #17a2b8 !important;
        }
        
        .text-info {
            color: #17a2b8 !important;
        }
        
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg admin-navbar navbar-dark py-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-crown me-2"></i>{{ config('app.name') }} Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('diskusi.*') ? 'active' : '' }}" href="{{ route('diskusi.index') }}">
                            <i class="fas fa-comments me-1"></i> Community
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="greeting-text">Hai, {{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="user-avatar me-2">
                                    @else
                                        <i class="fas fa-user-circle me-2 fa-2x text-muted"></i>
                                    @endif
                                    <div class="d-inline-block">
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('account.settings') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <div class="col-lg-2 d-none d-lg-block p-0">
                @include('layouts.shared.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 col-12 p-0">
                <div class="main-content p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>