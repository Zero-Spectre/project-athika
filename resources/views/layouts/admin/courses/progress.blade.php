@extends('layouts.admin.app')

@section('title', 'Student Progress')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Student Progress for "{{ $kursus->judul }}"</h1>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Courses
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
        <h5 class="mb-0">Student Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-user fa-2x text-muted"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        <span class="badge bg-primary">{{ $user->peran }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="mb-3">
                    <h6 class="text-muted">Course</h6>
                    <h5>{{ $kursus->judul }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Progress Details</h5>
    </div>
    <div class="card-body">
        @if($progressRecords->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Status</th>
                            <th>Completion Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($progressRecords as $progress)
                            <tr>
                                <td>{{ $progress->modul->judul }}</td>
                                <td>
                                    @if($progress->completed)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-secondary">Not Started</span>
                                    @endif
                                </td>
                                <td>
                                    @if($progress->completed)
                                        {{ $progress->completed_at->format('M d, Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-outline-danger" 
                        data-student-id="{{ $user->id }}"
                        data-student-name="{{ $user->name }}"
                        data-course-id="{{ $kursus->id }}"
                        data-bs-toggle="modal" 
                        data-bs-target="#resetProgressModal">
                    <i class="fas fa-redo me-1"></i> Reset All Progress
                </button>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                <h5>No progress records found</h5>
                <p class="text-muted">This student has not started any modules in this course yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle reset progress button clicks
    const resetButton = document.querySelector('.btn-outline-danger');
    const resetProgressForm = document.getElementById('resetProgressForm');
    const studentNameSpan = document.getElementById('studentName');
    
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const studentName = this.getAttribute('data-student-name');
            const courseId = this.getAttribute('data-course-id');
            
            // Set student name in modal
            studentNameSpan.textContent = studentName;
            
            // Set form action
            const formAction = `/admin/courses/${courseId}/students/${studentId}/progress/reset`;
            resetProgressForm.setAttribute('action', formAction);
        });
    }
});
</script>
@endsection