<!-- Shared Sidebar -->
<div class="sidebar p-3">
    <!-- Role-specific navigation -->
    @if(Auth::user()->peran == 'Admin')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users me-2"></i>Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                    <i class="fas fa-graduation-cap me-2"></i>Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-tags me-2"></i>Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-chart-bar me-2"></i>Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
            </li>
        </ul>
    @elseif(Auth::user()->peran == 'Instruktur')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('instruktur.dashboard') ? 'active' : '' }}" href="{{ route('instruktur.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('instruktur.courses*') ? 'active' : '' }}" href="{{ route('instruktur.courses.index') }}">
                    <i class="fas fa-graduation-cap me-2"></i>My Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('instruktur.analytics*') ? 'active' : '' }}" href="{{ route('instruktur.analytics.index') }}">
                    <i class="fas fa-chart-line me-2"></i>Analytics
                </a>
            </li>
        </ul>
    @elseif(Auth::user()->peran == 'Peserta')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peserta.dashboard') ? 'active' : '' }}" href="{{ route('peserta.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peserta.courses*') ? 'active' : '' }}" href="{{ route('peserta.courses.index') }}">
                    <i class="fas fa-graduation-cap me-2"></i>My Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peserta.quizzes*') ? 'active' : '' }}" href="{{ route('peserta.quizzes.index') }}">
                    <i class="fas fa-question-circle me-2"></i>Quizzes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peserta.progress*') ? 'active' : '' }}" href="{{ route('peserta.progress.index') }}">
                    <i class="fas fa-chart-line me-2"></i>Progress
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peserta.certificates*') ? 'active' : '' }}" href="{{ route('peserta.certificates.index') }}">
                    <i class="fas fa-certificate me-2"></i>Certificates
                </a>
            </li>
        </ul>
    @endif

    <!-- Shared navigation (Community Discussion) -->
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('diskusi*') ? 'active' : '' }}" href="{{ route('diskusi.index') }}">
                <i class="fas fa-comments me-2"></i>Community
            </a>
        </li>
        @if(request()->routeIs('diskusi*'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('diskusi.index') ? 'active' : '' }}" href="{{ route('diskusi.index') }}">
                    <i class="fas fa-list me-2"></i>All Topics
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('diskusi.create') ? 'active' : '' }}" href="{{ route('diskusi.create') }}">
                    <i class="fas fa-plus me-2"></i>New Topic
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('diskusi.index', ['resolved' => 'true']) }}">
                    <i class="fas fa-check-circle me-2"></i>Resolved
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('diskusi.index', ['resolved' => 'false']) }}">
                    <i class="fas fa-question-circle me-2"></i>Unresolved
                </a>
            </li>
            
            @if(request()->routeIs('diskusi.index'))
                <hr>
                <h6 class="text-muted">Categories</h6>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('diskusi.index') }}">
                        <i class="fas fa-globe me-2"></i>All Categories
                    </a>
                </li>
                @php
                    $categories = \App\Models\Kategori::all();
                @endphp
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('diskusi.index', ['kategori' => $category->id]) }}">
                            <i class="fas fa-tag me-2"></i>{{ $category->nama }}
                        </a>
                    </li>
                @endforeach
            @endif
        @endif
    </ul>
</div>