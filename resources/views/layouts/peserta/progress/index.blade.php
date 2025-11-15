@extends('layouts.peserta.app')

@section('title', 'My Progress')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">My Learning Progress</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if($courses->count() > 0)
            @foreach($courses as $course)
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">{{ $course->judul }}</h3>
                            @php
                                $totalModules = $course->moduls->count();
                                $completedModules = $course->moduls->filter(function ($module) {
                                    $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                                    return $progress && $progress->completed;
                                })->count();
                                $progressPercentage = $totalModules > 0 ? ($completedModules / $totalModules) * 100 : 0;
                            @endphp
                            <span class="badge bg-primary">{{ number_format($progressPercentage, 1) }}% Complete</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-custom bg-primary" role="progressbar" style="<?php echo 'width: ' . $progressPercentage . '%'; ?>"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Course Details</h5>
                                <p><strong>Instructor:</strong> {{ $course->instruktur->name }}</p>
                                <p><strong>Category:</strong> {{ $course->kategori->nama ?? 'Uncategorized' }}</p>
                                <p><strong>Total Modules:</strong> {{ $totalModules }}</p>
                                <p><strong>Completed Modules:</strong> {{ $completedModules }}</p>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Modules Progress</h5>
                                <div class="list-group">
                                    @foreach($course->moduls as $module)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $module->judul }}</span>
                                            @php
                                                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                                            @endphp
                                            @if($progress && $progress->completed)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning">In Progress</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h4>No progress data available</h4>
                    <p class="text-muted">You haven't enrolled in any courses yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Browse Courses</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection