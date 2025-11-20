@extends('layouts.peserta.app')

@section('title', $modul->judul)

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('peserta.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('peserta.courses.index') }}">My Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ route('peserta.courses.show', $modul->kursus->id) }}">{{ $modul->kursus->judul }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $modul->judul }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ $modul->judul }}</h2>
                    <div>
                        @if($modul->tipe_materi == 'Artikel')
                            <a href="{{ route('peserta.modules.export-pdf', $modul->id) }}" class="btn btn-outline-secondary btn-sm me-2" target="_blank">
                                <i class="fas fa-file-pdf"></i> Export to PDF
                            </a>
                        @endif
                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $modul->tipe_materi)) }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($modul->tipe_materi == 'Artikel')
                    <div class="mb-4">
                        {!! $modul->konten_teks !!}

                     
                    </div>
                @elseif($modul->tipe_materi == 'Video')
                    @if($modul->url_video)
                        <div class="ratio ratio-16x9 mb-4">
                            <iframe src="{{ $modul->url_video }}" title="{{ $modul->judul }}" allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No video content available for this module.
                        </div>
                    @endif
                @elseif($modul->tipe_materi == 'Kuis')
                    @if($modul->kuis)
                        <div class="alert alert-info">
                            <i class="fas fa-question-circle me-2"></i>
                            This module contains a quiz to test your knowledge.
                        </div>
                        <a href="{{ route('peserta.quizzes.show', $modul->kuis->id) }}" class="btn btn-primary">Take Quiz</a>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No quiz available for this module.
                        </div>
                    @endif
                @endif
                
                <div class="mt-4">
                    <form action="{{ route('peserta.modules.complete', $modul->id) }}" method="POST">
                        @csrf
                        @if($progress && $progress->completed)
                            <button type="submit" class="btn btn-success" disabled>
                                <i class="fas fa-check"></i> Completed
                            </button>
                            <small class="text-muted d-block mt-2">Completed on {{ $progress->completed_at->format('M d, Y') }}</small>
                        @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Mark as Completed
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection