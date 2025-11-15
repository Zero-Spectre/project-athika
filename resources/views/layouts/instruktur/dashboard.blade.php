@extends('layouts.instruktur.app')

@section('title', 'Instructor Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card bg-gradient-instructor text-white rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Welcome back, {{ Auth::user()->name ?? 'Instructor' }}!</h1>
                </div>
                <div class="text-end">
                    <div class="fs-5 fw-bold">{{ now()->format('l, F j') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-graduation-cap fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-primary">{{ $totalCourses ?? 0 }}</h3>
                <p class="text-muted mb-0">Courses</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-success">{{ $totalStudents ?? 0 }}</h3>
                <p class="text-muted mb-0">Students</p>
            </div>
        </div>
    </div>
    
    
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Courses</h5>
                <a href="{{ route('instruktur.courses.create') }}" class="btn btn-instructor btn-sm">
                    <i class="fas fa-plus me-1"></i>Create Course
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(isset($recentCourses) && $recentCourses->count() > 0)
                        @foreach($recentCourses as $course)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="course-card card h-100 border-0 shadow-sm">
                                    @if($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top rounded-top" alt="{{ $course->judul }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top rounded-top" alt="Course" style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ Str::limit($course->judul, 40) }}</h5>
                                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->deskripsi, 80) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge {{ $course->status_publish == 'Published' ? 'bg-success' : ($course->status_publish == 'Draft' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $course->status_publish }}
                                            </span>
                                            <span class="text-muted">
                                                <i class="fas fa-users me-1"></i> {{ $course->total_students }}
                                            </span>
                                        </div>
                                        @php
                                            // Calculate completion rate for this course
                                            $totalModules = $course->total_modules;
                                            $completionRate = 0;
                                            if ($totalModules > 0) {
                                                // Get all progress records for this course
                                                $progressRecords = $course->progresPesertas;
                                                $completedModules = $progressRecords->where('completed', true)->count();
                                                $totalModuleInstances = $progressRecords->count();
                                                $completionRate = $totalModuleInstances > 0 ? ($completedModules / $totalModuleInstances) * 100 : 0;
                                            }
                                        @endphp
                                        <div class="progress mb-2" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {!! $completionRate !!}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between small text-muted">
                                            <span>{{ number_format($completionRate, 1) }}% Completed</span>
                                            <span>{{ $course->total_students }} Students</span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('instruktur.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <a href="{{ route('instruktur.courses.show', $course) }}" class="btn btn-sm btn-outline-success">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                <h4>No courses found</h4>
                                <p class="text-muted">You haven't created any courses yet.</p>
                                <a href="{{ route('instruktur.courses.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Create Your First Course
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('instruktur.courses.index') }}" class="btn btn-link">View All Courses</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection