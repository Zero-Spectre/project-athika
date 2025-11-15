@extends('layouts.admin.app')

@section('title', 'Select Student')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Select Student for "{{ $kursus->judul }}"</h1>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Courses
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Students Enrolled in This Course</h5>
    </div>
    <div class="card-body">
        @php
            $students = \App\Models\User::where('peran', 'Peserta')
                ->whereHas('progresPesertas', function ($query) use ($kursus) {
                    $query->whereHas('modul', function ($query) use ($kursus) {
                        $query->where('kursus_id', $kursus->id);
                    });
                })
                ->get();
        @endphp

        @if($students->count() > 0)
            <div class="row">
                @foreach($students as $student)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $student->name }}</h5>
                                        <p class="text-muted mb-0">{{ $student->email }}</p>
                                    </div>
                                </div>
                                
                                @php
                                    $progressRecords = \App\Models\ProgresPeserta::where('user_id', $student->id)
                                        ->whereHas('modul', function ($query) use ($kursus) {
                                            $query->where('kursus_id', $kursus->id);
                                        })
                                        ->get();
                                    
                                    $completedModules = $progressRecords->where('completed', true)->count();
                                    $totalModules = $kursus->moduls->count();
                                    $progressPercentage = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
                                @endphp
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Progress</small>
                                        <small>{{ $progressPercentage }}%</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" 
                                             role="progressbar" 
                                             style="width: {{ $progressPercentage }}%" 
                                             aria-valuenow="{{ $progressPercentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('admin.courses.progress.show', ['kursus' => $kursus->id, 'user' => $student->id]) }}" 
                                   class="btn btn-primary w-100">
                                    <i class="fas fa-chart-line me-1"></i>View Progress
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>No students enrolled</h5>
                <p class="text-muted">No students have enrolled in this course yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection