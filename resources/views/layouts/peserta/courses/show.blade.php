@extends('layouts.peserta.app')

@section('title', $kursus->judul)

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('peserta.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('peserta.courses.index') }}">My Courses</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $kursus->judul }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="mb-3">{{ $kursus->judul }}</h1>
                        <p class="text-muted">Instructor: {{ $kursus->instruktur->name }}</p>
                        <p>{{ $kursus->deskripsi }}</p>
                    </div>
                    <div class="col-md-4">
                        @if($kursus->thumbnail)
                        <img src="{{ asset('storage/' . $kursus->thumbnail) }}" class="img-fluid rounded" alt="{{ $kursus->judul }}">
                        @else
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=300&q=80" class="img-fluid rounded" alt="Course">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h3 class="mb-4">Course Modules</h3>

        @if($kursus->moduls->count() > 0)
        <div class="accordion" id="modulesAccordion">
            @foreach($kursus->moduls as $index => $module)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $module->id }}">
                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $module->id }}">
                        <div class="d-flex align-items-center w-100">
                            <span class="me-3">
                                @php
                                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                                @endphp
                                @if($progress && $progress->completed)
                                <i class="fas fa-check-circle text-success"></i>
                                @else
                                <i class="far fa-circle"></i>
                                @endif
                            </span>
                            <span>{{ $module->judul }}</span>
                            <span class="badge bg-secondary ms-auto">{{ ucfirst(str_replace('_', ' ', $module->tipe_materi)) }}</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $module->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $module->id }}" data-bs-parent="#modulesAccordion">
                    <div class="accordion-body">
                        @if($module->tipe_materi == 'Artikel')
                        <div class="mb-3">
                            {!! $module->konten_teks !!}
                            <br>
                            <br>
                            sumber:
                            {!! $module->penjelasan !!}
                            <br>
                            <a href="{{ route('peserta.modules.export-pdf', $module->id) }}" class="btn btn-outline-secondary btn-sm me-2" target="_blank">
                                <i class="fas fa-file-pdf"></i> Export to PDF
                            </a>
                        </div>
                        @elseif($module->tipe_materi == 'Video')
                        @if($module->url_video)
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe src="{{ $module->url_video }}" title="{{ $module->judul }}" allowfullscreen></iframe>
                        </div>
                        @else
                        <p class="text-muted">No video content available for this module.</p>
                        @endif
                        @elseif($module->tipe_materi == 'Kuis')
                        @if($module->kuis)
                        <p>This module contains a quiz to test your knowledge.</p>
                        <a href="{{ route('peserta.quizzes.show', $module->kuis->first()->id) }}" class="btn btn-primary">Take Quiz</a>
                        @else
                        <p class="text-muted">No quiz available for this module.</p>
                        @endif
                        @endif

                        <div class="mt-3 float-end">
                            <a href="{{ route('diskusi.create', ['modul_id' => $module->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-comments me-1"></i>Discuss this Module
                            </a>
                        </div>


                        @if($module->tipe_materi != 'Kuis')
                        <form action="{{ route('peserta.modules.complete', $module->id) }}" method="POST">
                            @csrf
                            @php
                            $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                            @endphp
                            @if($progress && $progress->completed)
                            <button type="submit" class="btn btn-success" disabled>
                                <i class="fas fa-check"></i> Completed
                            </button>
                            @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Mark as Completed
                            </button>
                            @endif
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h4>No modules available</h4>
                <p class="text-muted">This course doesn't have any modules yet.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection