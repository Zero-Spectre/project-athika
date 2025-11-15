@extends('layouts.instruktur.app')

@section('title', 'My Courses')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">My Courses</h1>
            <a href="{{ route('instruktur.courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Create New Course
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

<div class="row">
    @forelse($courses as $course)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 course-card">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top" alt="{{ $course->judul }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $course->judul }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->deskripsi, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge 
                            @if($course->status_publish == 'Published') bg-success 
                            @elseif($course->status_publish == 'Draft') bg-warning 
                            @else bg-danger @endif">
                            {{ $course->status_publish }}
                        </span>
                        <span class="text-muted">
                            <i class="fas fa-layer-group me-1"></i> 
                            {{ $course->moduls->count() }} Modules
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('instruktur.courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('instruktur.courses.edit', $course) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('instruktur.courses.destroy', $course) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this course? This will delete all modules, quizzes, and student progress associated with this course.')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <h4>No courses found</h4>
                    <p class="text-muted">You haven't created any courses yet.</p>
                    <a href="{{ route('instruktur.courses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create Your First Course
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection