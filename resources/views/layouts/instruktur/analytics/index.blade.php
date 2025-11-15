@extends('layouts.instruktur.app')

@section('title', 'Instructor Analytics')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card instructor-navbar text-white rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Analytics Dashboard</h1>
                    <p class="mb-0 opacity-75">Track your course performance and student engagement</p>
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
                <h3 class="mb-1 fw-bold text-primary">{{ $totalCourses ?? 0 }}</h3>
                <p class="text-muted mb-0">Total Courses</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-success">{{ $totalStudents ?? 0 }}</h3>
                <p class="text-muted mb-0">Total Students</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <h3 class="mb-1 fw-bold text-warning">
                    {{ isset($completionRates) && count($completionRates) > 0 ? round(array_sum($completionRates) / count($completionRates), 1) : 0 }}%
                </h3>
                <p class="text-muted mb-0">Avg. Completion Rate</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Course Performance</h5>
            </div>
            <div class="card-body">
                <canvas id="coursePerformanceChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Top Performing Courses</h5>
            </div>
            <div class="card-body">
                @if(isset($topCourses) && count($topCourses) > 0)
                    @foreach($topCourses as $courseId => $completionRate)
                        @php
                            $course = $courses->firstWhere('id', $courseId);
                        @endphp
                        @if($course)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($course->judul, 25) }}</h6>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                                <span class="badge bg-success">{{ $completionRate }}%</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-chart-bar fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No course data available</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Student Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="studentDistributionChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">All Courses Overview</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Course Title</th>
                                <th>Students</th>
                                <th>Modules</th>
                                <th>Completion Rate</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($courses))
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $course->judul }}</td>
                                        <td>{{ $course->total_students }}</td>
                                        <td>{{ $course->total_modules }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="height: 8px; width: 100px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completionData[$course->id] ?? 0 }}%"></div>
                                                </div>
                                                <span>{{ $completionData[$course->id] ?? 0 }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $course->status_publish == 'Published' ? 'bg-success' : ($course->status_publish == 'Draft' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $course->status_publish }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare chart data
    var courseNames = @json(isset($courseNames) ? $courseNames : []);
    var completionRates = @json(isset($completionRates) ? $completionRates : []);
    var studentCounts = @json(isset($studentCounts) ? $studentCounts : []);
    
    // Only initialize charts if we have data
    if (courseNames.length > 0) {
        // Course performance chart
        var courseCtx = document.getElementById('coursePerformanceChart').getContext('2d');
        var coursePerformanceChart = new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: courseNames,
                datasets: [{
                    label: 'Completion Rate (%)',
                    data: completionRates,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
        
        // Student distribution chart
        var studentCtx = document.getElementById('studentDistributionChart').getContext('2d');
        var studentDistributionChart = new Chart(studentCtx, {
            type: 'doughnut',
            data: {
                labels: courseNames,
                datasets: [{
                    data: studentCounts,
                    backgroundColor: [
                        '#28a745',
                        '#208030',
                        '#4caf50',
                        '#8bc34a',
                        '#cddc39'
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
    }
});
</script>
@endsection