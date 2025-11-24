@extends('layouts.peserta.app')

@section('title', 'Participant Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card bg-gradient-participant text-white rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Welcome back, {{ Auth::user()->name ?? 'Participant' }}!</h1>
                    <p class="mb-0 opacity-75">Continue your learning journey today.</p>
                </div>
                <div class="text-end">
                    <div class="fs-5 fw-bold">{{ now()->format('l, F j') }}</div>
                    <div class="opacity-75">{{ now()->format('Y') }}</div>
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
                    <i class="fas fa-book-open fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-primary">{{ $enrolledCount ?? 0 }}</h3>
                <p class="text-muted mb-0">Enrolled Courses</p>
                <div class="mt-2">
                    <div class="d-flex align-items-center justify-content-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">2 from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-success">{{ $completedCount ?? 0 }}</h3>
                <p class="text-muted mb-0">Completed Courses</p>
                <div class="mt-2">
                    <div class="d-flex align-items-center justify-content-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">1 from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-certificate fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-warning">{{ $certificates->count() ?? 0 }}</h3>
                <p class="text-muted mb-0">Certificates Earned</p>
                <div class="mt-2">
                    <div class="d-flex align-items-center justify-content-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">1 from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Continue Learning</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(isset($enrolledCourses) && $enrolledCourses->count() > 0)
                        @foreach($enrolledCourses->take(2) as $course)
                            <div class="col-md-6 mb-4">
                                <div class="course-card card h-100 border-0 shadow-sm">
                                    @if($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top rounded-top" alt="{{ $course->judul }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top rounded-top" alt="Course" style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($course->judul, 40) }}</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Instructor: {{ $course->instruktur->name }}</span>
                                            @php
                                                $totalModules = $course->moduls->count();
                                                $completedModules = $course->moduls->filter(function ($module) {
                                                    return $module->progresPesertas->first() && $module->progresPesertas->first()->completed;
                                                })->count();
                                                $progressPercentage = $totalModules > 0 ? ($completedModules / $totalModules) * 100 : 0;
                                                $isCompleted = $totalModules > 0 && $completedModules == $totalModules;
                                            @endphp
                                            <span class="badge {{ $isCompleted ? 'bg-success' : 'bg-primary' }}">
                                                {{ $isCompleted ? 'Completed' : 'In Progress' }}
                                            </span>
                                        </div>
                                        <div class="progress mb-2" style="height: 8px;">
                                            <div class="progress-bar progress-bar-custom {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="<?php echo 'width: ' . $progressPercentage . '%'; ?>"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($progressPercentage, 1) }}% completed</small>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <a href="{{ route('peserta.courses.show', $course->id) }}" class="btn btn-participant w-100">
                                            {{ $isCompleted ? 'Review Course' : 'Continue Learning' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                <h4>You haven't enrolled in any courses yet</h4>
                                <p class="text-muted">Start learning by enrolling in a course.</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">Browse Courses</a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('peserta.courses.index') }}" class="btn btn-link">View All Courses</a>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Recommended Courses</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $recommendedCourses = \App\Models\Kursus::where('status_publish', 'Published')
                            ->whereNotIn('id', isset($enrolledCourses) ? $enrolledCourses->pluck('id')->toArray() : [])
                            ->take(2)
                            ->get();
                    @endphp
                    
                    @if($recommendedCourses->count() > 0)
                        @foreach($recommendedCourses as $course)
                            <div class="col-md-6 mb-4">
                                <div class="course-card card h-100 border-0 shadow-sm">
                                    @if($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top rounded-top" alt="{{ $course->judul }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1550439062-609e1531270e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top rounded-top" alt="Course" style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ Str::limit($course->judul, 40) }}</h5>
                                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->deskripsi, 80) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">
                                                <i class="fas fa-user me-1"></i> {{ $course->instruktur->name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <form action="{{ route('peserta.courses.enroll', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary w-100">Enroll Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-3">
                                <p class="text-muted mb-0">No recommended courses available at the moment.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Learning Progress</h5>
            </div>
            <div class="card-body">
                <canvas id="progressChart" height="200"></canvas>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Certificates</h5>
            </div>
            <div class="card-body">
                @if(isset($certificates) && $certificates->count() > 0)
                    @foreach($certificates->take(2) as $course)
                        <div class="certificate-card card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($course->judul, 30) }}</h6>
                                        @php
                                            $completionDate = null;
                                            $completedModules = $course->moduls->filter(function ($module) use (&$completionDate) {
                                                $progress = $module->progresPesertas->first();
                                                if ($progress && $progress->completed) {
                                                    if (!$completionDate || $progress->completed_at > $completionDate) {
                                                        $completionDate = $progress->completed_at;
                                                    }
                                                    return true;
                                                }
                                                return false;
                                            });
                                            $isCompleted = $course->moduls->count() > 0 && $completedModules->count() == $course->moduls->count();
                                        @endphp
                                        @if($isCompleted && $completionDate)
                                            <small class="text-muted">Issued: {{ $completionDate->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Download</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-certificate fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No certificates earned yet</p>
                    </div>
                @endif
                
                <div class="text-center mt-3">
                    <a href="{{ route('peserta.certificates.index') }}" class="btn btn-link">View All Certificates</a>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Upcoming Deadlines</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <div class="d-flex justify-content-between">
                            <span>Complete Module 5 Quiz</span>
                            <span class="badge bg-danger">2 days</span>
                        </div>
                        <small class="text-muted">Web Development Course</small>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="d-flex justify-content-between">
                            <span>Submit Project Assignment</span>
                            <span class="badge bg-warning">1 week</span>
                        </div>
                        <small class="text-muted">Mobile App Development</small>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="d-flex justify-content-between">
                            <span>Final Exam</span>
                            <span class="badge bg-success">2 weeks</span>
                        </div>
                        <small class="text-muted">Data Science Course</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('progressChart').getContext('2d');
        
        // Prepare chart data
        const progressData = <?php echo json_encode(isset($progressData) ? $progressData : []); ?>;
        const labels = Object.keys(progressData);
        const data = Object.values(progressData);
        
        const progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Courses Completed',
                    data: data,
                    borderColor: '#2575fc',
                    backgroundColor: 'rgba(37, 117, 252, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection