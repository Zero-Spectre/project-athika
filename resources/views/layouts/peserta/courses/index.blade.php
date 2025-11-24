@extends('layouts.peserta.app')

@section('title', 'My Courses')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">My Courses</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('peserta.courses.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="search" placeholder="Search courses..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="kategori">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-participant w-100">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if($courses->count() > 0)
        @foreach($courses as $course)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="course-card card h-100">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top" alt="{{ $course->judul }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top" alt="Course" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $course->judul }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->deskripsi, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Instructor: {{ $course->instruktur->name }}</span>
                            <span class="badge bg-primary">{{ $course->kategori->nama ?? 'Uncategorized' }}</span>
                        </div>
                        
                        @php
                            $totalModules = $course->moduls->count();
                            $completedModules = $course->moduls->filter(function ($module) {
                                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                                return $progress && $progress->completed;
                            })->count();
                            $progressPercentage = $totalModules > 0 ? ($completedModules / $totalModules) * 100 : 0;
                            $isCompleted = $totalModules > 0 && $completedModules == $totalModules;
                        @endphp
                        
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-custom {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="<?php echo 'width: ' . $progressPercentage . '%'; ?>"></div>
                        </div>
                        <small class="text-muted">{{ $completedModules }}/{{ $totalModules }} modules completed</small>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('peserta.courses.show', $course->id) }}" class="btn btn-participant w-100">
                            {{ $isCompleted ? 'Review Course' : 'Continue Learning' }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h4>No courses found</h4>
                    <p class="text-muted">You haven't enrolled in any courses yet or no courses match your search criteria.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Browse Courses</a>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Recommended Courses Section --}}
@if(isset($recommendedCourses) && $recommendedCourses->count() > 0)
<div class="row mt-5">
    <div class="col-12">
        <h2 class="mb-4">Recommended Courses</h2>
    </div>
    
    @foreach($recommendedCourses as $course)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="course-card card h-100 border-0 shadow-sm">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top rounded-top" alt="{{ $course->judul }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top rounded-top" alt="Course" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $course->judul }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->deskripsi, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Instructor: {{ $course->instruktur->name }}</span>
                        <span class="badge bg-secondary">{{ $course->kategori->nama ?? 'General' }}</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <form action="{{ route('peserta.courses.enroll', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-participant w-100">
                            Enroll Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    
    <div class="col-12 text-center mt-3">
        <a href="{{ route('home') }}" class="btn btn-link">View All Available Courses</a>
    </div>
</div>
@endif
@endsection