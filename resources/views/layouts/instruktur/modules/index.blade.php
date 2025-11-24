@extends('layouts.instruktur.app')

@section('title', 'Course Modules')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Modules for "{{ $kursus->judul }}"</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('instruktur.courses.show', $kursus) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Course
                </a>
                <a href="{{ route('instruktur.modules.create', $kursus) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Module
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
                                        <a href="{{ route('instruktur.modules.edit', [$kursus, $modul]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('diskusi.create', ['modul_id' => $modul->id]) }}" class="btn btn-sm btn-outline-success" title="Create Discussion">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $modul->id }}" data-title="{{ $modul->judul }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <form id="delete-form-{{ $modul->id }}" action="{{ route('instruktur.modules.destroy', [$kursus, $modul]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h4>No modules created yet</h4>
                <p class="text-muted">Create your first module to get started.</p>
                <a href="{{ route('instruktur.modules.create', $kursus) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Module
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const modulId = this.getAttribute('data-id');
            const modulTitle = this.getAttribute('data-title');
            
            if (confirm(`Are you sure you want to delete the module "${modulTitle}"? This action cannot be undone.`)) {
                document.getElementById(`delete-form-${modulId}`).submit();
            }
        });
    });
});
</script>
@endsection