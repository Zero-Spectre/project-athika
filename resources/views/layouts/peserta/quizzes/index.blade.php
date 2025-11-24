@extends('layouts.peserta.app')

@section('title', 'My Quizzes')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">My Quizzes</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('peserta.quizzes.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select class="form-select" name="kategori">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-participant w-100">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if($quizzes->count() > 0)
        @foreach($quizzes as $quiz)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($quiz->question, 50) }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($quiz->modul->kursus->judul, 60) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-primary">Module: {{ $quiz->modul->judul }}</span>
                            
                            @php
                                $hasTaken = \App\Models\HasilKuis::where('user_id', Auth::id())
                                    ->where('modul_id', $quiz->modul_id)
                                    ->exists();
                            @endphp
                            
                            @if($hasTaken)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('peserta.quizzes.show', $quiz->id) }}" class="btn btn-participant w-100">
                            @if($hasTaken)
                                Review Quiz
                            @else
                                Take Quiz
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                    <h4>No quizzes available</h4>
                    <p class="text-muted">You don't have any quizzes assigned yet.</p>
                    <a href="{{ route('peserta.courses.index') }}" class="btn btn-primary">View Courses</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection