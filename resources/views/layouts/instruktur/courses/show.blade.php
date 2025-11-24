@extends('layouts.instruktur.app')

@section('title', $kursus->judul)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">{{ $kursus->judul }}</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('instruktur.courses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Courses
                </a>
                <a href="{{ route('instruktur.courses.edit', $kursus) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>Edit Course
                </a>
            </div>
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
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Course Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        @if($kursus->thumbnail)
                            <img src="{{ asset('storage/' . $kursus->thumbnail) }}" class="img-fluid rounded" alt="{{ $kursus->judul }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th>Category:</th>
                                <td>{{ $kursus->kategori->nama }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge 
                                        @if($kursus->status_publish == 'Published') bg-success 
                                        @elseif($kursus->status_publish == 'Draft') bg-warning 
                                        @else bg-danger @endif">
                                        {{ $kursus->status_publish }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Modules:</th>
                                <td>{{ $kursus->moduls->count() }}</td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $kursus->created_at->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6 class="mt-3">Description</h6>
                <p>{{ $kursus->deskripsi }}</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Course Modules</h5>
                <a href="{{ route('instruktur.modules.create', $kursus) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Add Module
                </a>
            </div>
            <div class="card-body">
                @if($kursus->moduls->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Quizzes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kursus->moduls->sortBy('urutan') as $modul)
                                    <tr>
                                        <td>{{ $modul->urutan }}</td>
                                        <td>{{ $modul->judul }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $modul->tipe_materi }}</span>
                                        </td>
                                        <td>{{ $modul->kuis->count() }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if($modul->tipe_materi === 'Kuis')
                                                    <a href="{{ route('instruktur.modules.quizzes.index', $modul) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-question-circle me-1"></i>Manage Quizzes
                                                    </a>
                                                @endif
                                                <a href="{{ route('instruktur.modules.edit', $modul) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <form action="{{ route('instruktur.modules.destroy', $modul) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this module?')">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5>No modules yet</h5>
                        <p class="text-muted">Create your first module to get started.</p>
                        <a href="{{ route('instruktur.modules.create', $kursus) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Module
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('instruktur.modules.create', $kursus) }}" class="btn btn-primary">
                        <i class="fas fa-book me-1"></i>Create Module
                    </a>
                    <a href="{{ route('instruktur.courses.progress', $kursus) }}" class="btn btn-info">
                        <i class="fas fa-chart-line me-1"></i>View Student Progress
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Course Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="stat-card bg-light p-3 rounded">
                            <h4 class="mb-0">{{ $kursus->moduls->count() }}</h4>
                            <small class="text-muted">Modules</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-card bg-light p-3 rounded">
                            <h4 class="mb-0">{{ $kursus->moduls->where('tipe_materi', 'Kuis')->sum(function($modul) { return $modul->kuis->count(); }) }}</h4>
                            <small class="text-muted">Quizzes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection