@extends('layouts.admin.app')

@section('title', 'Admin - Courses Management')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Courses Management</h1>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Courses</h5>
                <button class="btn btn-primary" disabled>
                    <i class="fas fa-plus me-1"></i>Add New Course
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Instructor</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Modules</th>
                                <th>Students</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($courses))
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $course->id }}</td>
                                        <td>{{ $course->judul }}</td>
                                        <td>{{ $course->instruktur->name ?? 'N/A' }}</td>
                                        <td>{{ $course->kategori->nama ?? 'N/A' }}</td>
                                        <td>
                                            @if($course->status_publish == 'Published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($course->status_publish == 'Draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $course->moduls->count() }}</td>
                                        <td>
                                            @php
                                                $studentCount = \App\Models\ProgresPeserta::whereHas('modul', function($query) use ($course) {
                                                    $query->where('kursus_id', $course->id);
                                                })->distinct('user_id')->count('user_id');
                                            @endphp
                                            {{ $studentCount }}
                                        </td>
                                        <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="{{ route('admin.courses.students.select', $course->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-users me-1"></i>Students
                                            </a>
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this course? This will delete all modules, quizzes, and student progress associated with this course.')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>1</td>
                                    <td>Web Development Fundamentals</td>
                                    <td>John Smith</td>
                                    <td>Programming</td>
                                    <td><span class="badge bg-success">Published</span></td>
                                    <td>12</td>
                                    <td>25</td>
                                    <td>2025-01-15</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="#" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-users me-1"></i>Students
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Data Science Essentials</td>
                                    <td>Sarah Johnson</td>
                                    <td>Data Science</td>
                                    <td><span class="badge bg-warning">Draft</span></td>
                                    <td>8</td>
                                    <td>18</td>
                                    <td>2025-02-20</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="#" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-users me-1"></i>Students
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($courses))
                    <div class="d-flex justify-content-center">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection