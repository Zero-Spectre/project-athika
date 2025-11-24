@extends('layouts.instruktur.app')

@section('title', 'Module Quizzes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Quizzes for "{{ $modul->judul }}"</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('instruktur.courses.show', $modul->kursus) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Course
                </a>
                <a href="{{ route('instruktur.modules.quizzes.create', $modul) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Quiz
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
        <h5 class="mb-0">Quiz Questions</h5>
        <a href="{{ route('instruktur.modules.quizzes.create', $modul) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Quiz Question
        </a>
    </div>
    <div class="card-body">
        @if($modul->kuis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Correct Answer</th>
                            <th>Score Weight</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modul->kuis as $index => $quiz)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Str::limit($quiz->question, 50) }}</td>
                                <td>{{ $quiz->correct_answer }}. {{ $quiz->{'option_' . strtolower($quiz->correct_answer)} }}</td>
                                <td>{{ $quiz->score_weight }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('instruktur.modules.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('instruktur.modules.quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this quiz question?')">
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
                <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                <h5>No quiz questions yet</h5>
                <p class="text-muted">Create your first quiz question to get started.</p>
                <a href="{{ route('instruktur.modules.quizzes.create', $modul) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Quiz Question
                </a>
            </div>
        @endif
    </div>
</div>
@endsection