@extends('layouts.peserta.app')

@section('title', 'My Certificates')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">My Certificates</h1>
    </div>
</div>

<div class="row">
    @if(isset($courses) && $courses->count() > 0)
        @foreach($courses as $course)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card certificate-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="certificate-icon mb-3">
                            <i class="fas fa-certificate fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">{{ $course->judul }}</h5>
                        <p class="text-muted">Instructor: {{ $course->instruktur->name ?? 'Unknown' }}</p>
                        
                        @php
                            $completionDate = null;
                            $completedModules = $course->moduls->filter(function ($module) use (&$completionDate) {
                                $progress = $module->progresPesertas->firstWhere('user_id', Auth::id());
                                if ($progress && $progress->completed) {
                                    if (!$completionDate || $progress->completed_at > $completionDate) {
                                        $completionDate = $progress->completed_at;
                                    }
                                    return true;
                                }
                                return false;
                            });
                        @endphp
                        
                        @if($completionDate)
                            <div class="completion-date mb-3">
                                <small class="text-muted">Completed on {{ $completionDate->format('M d, Y') }}</small>
                            </div>
                            <a href="{{ route('peserta.certificate.view', $course->id) }}" class="btn btn-outline-success">
                                <i class="fas fa-eye me-2"></i>View Certificate
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                    <h4>No certificates earned yet</h4>
                    <p class="text-muted">Complete courses to earn certificates and see them here.</p>
                    <a href="{{ route('peserta.courses.index') }}" class="btn btn-primary">View Courses</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection