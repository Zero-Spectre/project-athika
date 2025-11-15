@extends('layouts.admin.app')

@section('title', 'Admin - Reports')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Reports & Analytics</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="card stat-card stat-card-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted">Total Users</h5>
                        <h2 class="mb-0">{{ $totalUsers ?? 1248 }}</h2>
                    </div>
                    <div class="icon-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card stat-card-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted">Total Courses</h5>
                        <h2 class="mb-0">{{ $totalCourses ?? 142 }}</h2>
                    </div>
                    <div class="icon-circle bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card stat-card-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted">Categories</h5>
                        <h2 class="mb-0">{{ $totalCategories ?? 24 }}</h2>
                    </div>
                    <div class="icon-circle bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-tags fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card stat-card stat-card-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-muted">Enrollments</h5>
                        <h2 class="mb-0">3,842</h2>
                    </div>
                    <div class="icon-circle bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-book-open fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">User Distribution by Role</h5>
            </div>
            <div class="card-body">
                <canvas id="userDistributionChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Courses by Category</h5>
            </div>
            <div class="card-body">
                <canvas id="courseDistributionChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
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
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentActivity))
                                @foreach($recentActivity as $activity)
                                    <tr>
                                        <td>{{ $activity['user'] }}</td>
                                        <td>{{ $activity['action'] }}</td>
                                        <td>{{ $activity['item'] }}</td>
                                        <td>{{ $activity['time'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>John Doe</td>
                                    <td>Created</td>
                                    <td>Web Development Course</td>
                                    <td>2 hours ago</td>
                                </tr>
                                <tr>
                                    <td>Sarah Johnson</td>
                                    <td>Enrolled</td>
                                    <td>Data Science Course</td>
                                    <td>5 hours ago</td>
                                </tr>
                                <tr>
                                    <td>Michael Chen</td>
                                    <td>Completed</td>
                                    <td>UX Design Quiz</td>
                                    <td>1 day ago</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User distribution chart
    var userCtx = document.getElementById('userDistributionChart').getContext('2d');
    var adminCount = "{{ $userDistribution['Admin'] ?? 3 }}";
    var instructorCount = "{{ $userDistribution['Instruktur'] ?? 42 }}";
    var participantCount = "{{ $userDistribution['Peserta'] ?? 1203 }}";
    
    var userDistributionChart = new Chart(userCtx, {
        type: 'bar',
        data: {
            labels: ['Admin', 'Instructor', 'Participant'],
            datasets: [{
                label: 'Number of Users',
                data: [parseInt(adminCount), parseInt(instructorCount), parseInt(participantCount)],
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Course distribution chart
    var courseCtx = document.getElementById('courseDistributionChart').getContext('2d');
    
    // Prepare course data from PHP
    var courseLabels = ['Programming', 'Data Science', 'Design', 'Business'];
    var courseData = [42, 28, 15, 18];
    
    var courseDistributionChart = new Chart(courseCtx, {
        type: 'pie',
        data: {
            labels: courseLabels,
            datasets: [{
                data: courseData,
                backgroundColor: [
                    '#2575fc',
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#6f42c1',
                    '#20c997'
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