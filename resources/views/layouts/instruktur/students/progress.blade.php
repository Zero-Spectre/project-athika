@extends('layouts.instruktur.app')

@section('title', 'Student Progress')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Student Progress for "{{ $kursus->judul }}"</h1>
            <a href="{{ route('instruktur.courses.show', $kursus) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Course
            </a>
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

<!-- Reset Progress Confirmation Modal -->
<div class="modal fade" id="resetProgressModal" tabindex="-1" aria-labelledby="resetProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetProgressModalLabel">Confirm Reset Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reset this student's progress? This action cannot be undone.</p>
                <p><strong>Student:</strong> <span id="studentName"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="resetProgressForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Reset Progress</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Progress Overview</h5>
    </div>
    <div class="card-body">
        @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student</th>
                            @foreach($modules as $module)
                                <th>{{ $module->judul }}</th>
                            @endforeach
                            <th>Overall Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $student->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $student->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                
                                @foreach($modules as $module)
                                    @php
                                        $progress = $student->progresPesertas->firstWhere('modul_id', $module->id);
                                    @endphp
                                    <td>
                                        @if($progress && $progress->completed)
                                            <span class="badge bg-success">Completed</span>
                                            <br>
                                            <small class="text-muted">{{ $progress->completed_at->format('M d, Y') }}</small>
                                        @else
                                            <span class="badge bg-secondary">Not Started</span>
                                        @endif
                                    </td>
                                @endforeach
                                
                                @php
                                    $completedModules = $student->progresPesertas->where('completed', true)->count();
                                    $totalModules = $modules->count();
                                    $progressPercentage = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
                                @endphp
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: <?php echo $progressPercentage; ?>%" 
                                                 aria-valuenow="{{ $progressPercentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ $progressPercentage }}%</span>
                                    </div>
                                    <small class="text-muted">{{ $completedModules }}/{{ $totalModules }} modules completed</small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger reset-progress-btn" 
                                            data-student-id="{{ $student->id }}"
                                            data-student-name="{{ $student->name }}"
                                            data-course-id="{{ $kursus->id }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#resetProgressModal">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>No students enrolled</h5>
                <p class="text-muted">No students have enrolled in this course yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle reset progress button clicks
    const resetButtons = document.querySelectorAll('.reset-progress-btn');
    const resetProgressForm = document.getElementById('resetProgressForm');
    const studentNameSpan = document.getElementById('studentName');
    
    resetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const studentName = this.getAttribute('data-student-name');
            const courseId = this.getAttribute('data-course-id');
            
            // Set student name in modal
            studentNameSpan.textContent = studentName;
            
            // Set form action
            const formAction = `/instruktur/courses/${courseId}/students/${studentId}/progress/reset`;
            resetProgressForm.setAttribute('action', formAction);
        });
    });
});
</script>
@endsection