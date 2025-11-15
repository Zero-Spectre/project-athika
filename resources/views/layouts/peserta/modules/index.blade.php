@extends('layouts.peserta.app')

@section('title', 'Course Modules')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('peserta.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('peserta.courses.index') }}">My Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Modules</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Course Modules</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if($kursus)
            <div class="card mb-4">
                <div class="card-body">
                    <h3>{{ $kursus->judul }}</h3>
                    <p class="text-muted">{{ $kursus->deskripsi }}</p>
                </div>
            </div>
            
            <div class="row">
                @foreach($kursus->moduls as $module)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card module-item h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">{{ $module->judul }}</h5>
                                    @php
                                        $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                                    @endphp
                                    @if($progress && $progress->completed)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning">In Progress</span>
                                    @endif
                                </div>
                                <p class="card-text">{{ Str::limit($module->konten_teks, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $module->tipe_materi)) }}</span>
                                    <a href="{{ route('peserta.modules.show', $module->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h4>No course selected</h4>
                    <p class="text-muted">Please select a course to view its modules.</p>
                    <a href="{{ route('peserta.courses.index') }}" class="btn btn-primary">View Courses</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection