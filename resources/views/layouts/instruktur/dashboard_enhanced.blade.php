@extends('layouts.instruktur.app')

@section('title', 'Instructor Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card bg-gradient-instructor text-white rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Welcome back, {{ Auth::user()->name ?? 'Instructor' }}!</h1>
                    <p class="mb-0 opacity-75">Here's your teaching overview for today.</p>
                </div>
                <div class="text-end">
                    <div class="fs-5 fw-bold">{{ now()->format('l, F j') }}</div>
                    <div class="opacity-75">{{ now()->format('Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-graduation-cap fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-primary">12</h3>
                <p class="text-muted mb-0">Courses</p>
                <div class="mt-2">
                    <div class="d-flex align-items-center justify-content-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">5% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-success">1,248</h3>
                <p class="text-muted mb-0">Students</p>
                <div class="mt-2">
                    <div class="d-flex align-items-center justify-content-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">12% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-star fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-warning">4.8</h3>
                <p class="text-muted mb-0">Average Rating</p>
                <div class="mt-2">
                    <div class="d-flex align-items-center justify-content-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">0.2 from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Courses</h5>
                <a href="{{ route('instruktur.courses.create') }}" class="btn btn-instructor btn-sm">
                    <i class="fas fa-plus me-1"></i>Create Course
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="course-card card h-100 border-0 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top rounded-top" alt="Course" style="height: 150px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Web Development Fundamentals</h5>
                                <p class="card-text text-muted flex-grow-1">Learn HTML, CSS, and JavaScript to build responsive websites.</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary">Published</span>
                                    <span class="text-muted">
                                        <i class="fas fa-users me-1"></i> 428
                                    </span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>75% Completed</span>
                                    <span>32/42 Students</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="#" class="btn btn-sm btn-outline-success">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="course-card card h-100 border-0 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=200&q=80" class="card-img-top rounded-top" alt="Course" style="height: 150px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Data Science Essentials</h5>
                                <p class="card-text text-muted flex-grow-1">Master Python, Pandas, and machine learning algorithms.</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-warning">Draft</span>
                                    <span class="text-muted">
                                        <i class="fas fa-users me-1"></i> 0
                                    </span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"></div>
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>30% Completed</span>
                                    <span>0/0 Students</span>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="#" class="btn btn-sm btn-outline-success">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('instruktur.courses.index') }}" class="btn btn-link">View All Courses</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Recent Student Feedback</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <strong>Web Development Fundamentals</strong>
                        <span class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                    </div>
                    <p class="text-muted mb-2">"The course content is excellent and well-structured. The instructor is very knowledgeable."</p>
                    <small class="text-muted">- Sarah Johnson, 2 days ago</small>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <strong>Mobile App Development</strong>
                        <span class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <p class="text-muted mb-2">"Great course! I was able to build my first app after completing this course."</p>
                    <small class="text-muted">- Michael Chen, 1 week ago</small>
                </div>
                
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <strong>UX Design Principles</strong>
                        <span class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </span>
                    </div>
                    <p class="text-muted mb-2">"Very informative course with practical examples. Could use more interactive elements."</p>
                    <small class="text-muted">- Emma Rodriguez, 2 weeks ago</small>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Upcoming Tasks</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <div class="d-flex justify-content-between">
                            <span>Create new module for Web Dev Course</span>
                            <span class="badge bg-danger">Due Today</span>
                        </div>
                        <small class="text-muted">Complete by 11:59 PM</small>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="d-flex justify-content-between">
                            <span>Review student submissions</span>
                            <span class="badge bg-warning">3 days</span>
                        </div>
                        <small class="text-muted">Data Science Course</small>
                    </li>
                    <li class="list-group-item px-0">
                        <div class="d-flex justify-content-between">
                            <span>Update Mobile App Course content</span>
                            <span class="badge bg-success">1 week</span>
                        </div>
                        <small class="text-muted">Add new Flutter examples</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection