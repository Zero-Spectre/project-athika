@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card bg-gradient-primary text-white rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Welcome back, Admin!</h1>
                    <p class="mb-0 opacity-75">Here's what's happening with your platform today.</p>
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
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Users</h5>
                        <h2 class="mb-0 fw-bold text-primary">{{ $totalUsers ?? 1248 }}</h2>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">12% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Courses</h5>
                        <h2 class="mb-0 fw-bold text-success">{{ $totalCourses ?? 142 }}</h2>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">8% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Categories</h5>
                        <h2 class="mb-0 fw-bold text-warning">{{ $totalCategories ?? 24 }}</h2>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-tags fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">3% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Enrollments</h5>
                        <h2 class="mb-0 fw-bold text-danger">3,842</h2>
                    </div>
                    <div class="icon-circle bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-book-open fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">15% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Course</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Enrolled</td>
                                <td>Web Development Fundamentals</td>
                                <td>2 hours ago</td>
                            </tr>
                            <tr>
                                <td>Sarah Johnson</td>
                                <td>Completed</td>
                                <td>Data Science Essentials</td>
                                <td>5 hours ago</td>
                            </tr>
                            <tr>
                                <td>Michael Chen</td>
                                <td>Created</td>
                                <td>Mobile App Development</td>
                                <td>1 day ago</td>
                            </tr>
                            <tr>
                                <td>Emma Rodriguez</td>
                                <td>Rated</td>
                                <td>UX Design Principles</td>
                                <td>1 day ago</td>
                            </tr>
                            <tr>
                                <td>David Wilson</td>
                                <td>Enrolled</td>
                                <td>Cloud Computing Basics</td>
                                <td>2 days ago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">User Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="userDistributionChart" height="200"></canvas>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Recent Users</h5>
            </div>
            <div class="card-body">
                @if(isset($recentUsers))
                    @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->peran }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" alt="User" width="40" height="40">
                        <div>
                            <h6 class="mb-0">John Doe</h6>
                            <small class="text-muted">Student</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle me-3" alt="User" width="40" height="40">
                        <div>
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <small class="text-muted">Instructor</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg" class="rounded-circle me-3" alt="User" width="40" height="40">
                        <div>
                            <h6 class="mb-0">Michael Chen</h6>
                            <small class="text-muted">Student</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare data for the chart
    var adminCount = "{{ $userStats['admin'] ?? 3 }}";
    var instructorCount = "{{ $userStats['instruktur'] ?? 42 }}";
    var participantCount = "{{ $userStats['peserta'] ?? 1203 }}";
    
    // Convert to numbers
    adminCount = parseInt(adminCount);
    instructorCount = parseInt(instructorCount);
    participantCount = parseInt(participantCount);
    
    // User distribution chart
    var ctx = document.getElementById('userDistributionChart').getContext('2d');
    var userDistributionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Instructor', 'Participant'],
            datasets: [{
                data: [adminCount, instructorCount, participantCount],
                backgroundColor: [
                    '#2575fc',
                    '#28a745',
                    '#ffc107'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endsection