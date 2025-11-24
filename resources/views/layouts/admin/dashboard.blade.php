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
    <!-- User Statistics -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Users</h5>
                        <h2 class="mb-0 fw-bold text-primary">{{ $totalUsers ?? 0 }}</h2>
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
    
    <!-- Course Statistics -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Courses</h5>
                        <h2 class="mb-0 fw-bold text-success">{{ $totalCourses ?? 0 }}</h2>
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
    
    <!-- Category Statistics -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Categories</h5>
                        <h2 class="mb-0 fw-bold text-warning">{{ $totalCategories ?? 0 }}</h2>
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
    
    <!-- Enrollment Statistics -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Enrollments</h5>
                        <h2 class="mb-0 fw-bold text-danger">{{ $totalEnrollments ?? 0 }}</h2>
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

<!-- Additional Statistics Row -->
<div class="row mb-4">
    <!-- Discussions -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Discussions</h5>
                        <h2 class="mb-0 fw-bold text-info">{{ $totalDiscussions ?? 0 }}</h2>
                    </div>
                    <div class="icon-circle bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-comments fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">7% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Published Courses -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Published Courses</h5>
                        <h2 class="mb-0 fw-bold text-success">{{ $courseStats['published'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">5% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Instructors -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Instructors</h5>
                        <h2 class="mb-0 fw-bold text-purple">{{ $userStats['instruktur'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-circle bg-purple bg-opacity-10 text-purple rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-chalkboard-teacher fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">4% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Students -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted mb-1">Students</h5>
                        <h2 class="mb-0 fw-bold text-teal">{{ $userStats['peserta'] ?? 0 }}</h2>
                    </div>
                    <div class="icon-circle bg-teal bg-opacity-10 text-teal rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-user-graduate fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span class="small">18% from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activity -->
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
                                <th>Item</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentActivity) && count($recentActivity) > 0)
                                @foreach($recentActivity as $activity)
                                    <tr>
                                        <td>{{ $activity['user'] }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($activity['type'] == 'enrollment') bg-primary
                                                @elseif($activity['type'] == 'completion') bg-success
                                                @elseif($activity['type'] == 'creation') bg-warning
                                                @elseif($activity['type'] == 'discussion') bg-info
                                                @else bg-secondary
                                                @endif">
                                                {{ $activity['action'] }}
                                            </span>
                                        </td>
                                        <td>{{ $activity['item'] }}</td>
                                        <td>{{ $activity['time'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No recent activity</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Enrollment Trends -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Enrollment Trends</h5>
            </div>
            <div class="card-body">
                <canvas id="enrollmentTrendsChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Column -->
    <div class="col-lg-4 mb-4">
        <!-- User Distribution -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">User Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="userDistributionChart" height="200"></canvas>
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Recent Users</h5>
            </div>
            <div class="card-body">
                @if(isset($recentUsers) && $recentUsers->count() > 0)
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
                    <div class="text-center py-3">
                        <i class="fas fa-user fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No recent users</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-graduation-cap me-2"></i>Manage Courses
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-warning">
                        <i class="fas fa-tags me-2"></i>Manage Categories
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-chart-bar me-2"></i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare data for the chart
    var adminCount = "{{ $userStats['admin'] ?? 0 }}";
    var instructorCount = "{{ $userStats['instruktur'] ?? 0 }}";
    var participantCount = "{{ $userStats['peserta'] ?? 0 }}";
    
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
    
    // Enrollment trends chart
    var trendsCtx = document.getElementById('enrollmentTrendsChart').getContext('2d');
    var enrollmentTrendsChart = new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Enrollments',
                data: [120, 190, 150, 220, 180, 250],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection