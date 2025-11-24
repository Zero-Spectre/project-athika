@extends('layouts.instruktur.app')

@section('title', 'Create Quiz')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Create Quiz for "{{ $modul->judul }}"</h1>
            <a href="{{ route('instruktur.modules.quizzes.index', $modul) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Quizzes
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quiz Question</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('instruktur.modules.quizzes.store', $modul) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" id="question" name="question" rows="3" required>{{ old('question') }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="option_a" class="form-label">Option A</label>
                        <input type="text" class="form-control" id="option_a" name="option_a" value="{{ old('option_a') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="option_b" class="form-label">Option B</label>
                        <input type="text" class="form-control" id="option_b" name="option_b" value="{{ old('option_b') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="option_c" class="form-label">Option C</label>
                        <input type="text" class="form-control" id="option_c" name="option_c" value="{{ old('option_c') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="option_d" class="form-label">Option D</label>
                        <input type="text" class="form-control" id="option_d" name="option_d" value="{{ old('option_d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <select class="form-select" id="correct_answer" name="correct_answer" required>
                            <option value="">Select the correct answer</option>
                            <option value="A" {{ old('correct_answer') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('correct_answer') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('correct_answer') == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('correct_answer') == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="score_weight" class="form-label">Score Weight</label>
                        <input type="number" class="form-control" id="score_weight" name="score_weight" value="{{ old('score_weight', 1) }}" min="1" required>
                        <div class="form-text">The points awarded for correctly answering this question.</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('instruktur.modules.quizzes.index', $modul) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Quiz Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection