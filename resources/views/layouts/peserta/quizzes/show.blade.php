@extends('layouts.peserta.app')

@section('title', 'Quiz: ' . Str::limit($kuis->question, 30))

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('peserta.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('peserta.quizzes.index') }}">My Quizzes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Quiz</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h2 class="mb-0">Quiz</h2>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Course:</strong> {{ $kuis->modul->kursus->judul }}<br>
                    <strong>Module:</strong> {{ $kuis->modul->judul }}
                </div>
                
                <h4 class="mb-4">{{ $kuis->question }}</h4>
                
                @if($hasTakenQuiz)
                    @php
                        $quizResult = \App\Models\HasilKuis::where('user_id', Auth::id())
                            ->where('modul_id', $kuis->modul_id)
                            ->first();
                    @endphp
                    
                    <div class="alert alert-{{ $quizResult->score >= 70 ? 'success' : 'danger' }} mb-4">
                        <h5 class="alert-heading">
                            @if($quizResult->score >= 70)
                                <i class="fas fa-check-circle me-2"></i> Quiz Completed!
                            @else
                                <i class="fas fa-times-circle me-2"></i> Quiz Result
                            @endif
                        </h5>
                        <p class="mb-0">Your score: <strong>{{ $quizResult->score }}%</strong></p>
                        @if($quizResult->score >= 70)
                            <p class="mb-0">Congratulations! You passed this quiz.</p>
                        @else
                            <p class="mb-0">You need to score at least 70% to pass. Please review the material and try again.</p>
                        @endif
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('peserta.courses.show', $kuis->modul->kursus->id) }}" class="btn btn-primary">Back to Course</a>
                    </div>
                @else
                    <form action="{{ route('peserta.quizzes.submit', $kuis->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="answer" id="optionA" value="A" required>
                                <label class="form-check-label" for="optionA">
                                    A. {{ $kuis->option_a }}
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="answer" id="optionB" value="B" required>
                                <label class="form-check-label" for="optionB">
                                    B. {{ $kuis->option_b }}
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="answer" id="optionC" value="C" required>
                                <label class="form-check-label" for="optionC">
                                    C. {{ $kuis->option_c }}
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="answer" id="optionD" value="D" required>
                                <label class="form-check-label" for="optionD">
                                    D. {{ $kuis->option_d }}
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('peserta.courses.show', $kuis->modul->kursus->id) }}" class="btn btn-secondary">Back to Course</a>
                            <button type="submit" class="btn btn-primary">Submit Answer</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection