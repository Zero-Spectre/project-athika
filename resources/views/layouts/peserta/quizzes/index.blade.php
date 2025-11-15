@extends('layouts.peserta.app')

@section('title', 'My Quizzes')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">My Quizzes</h1>
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