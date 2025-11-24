@extends('diskusi.app')

@section('title', 'Community Discussion')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Community Discussion</h1>
            <a href="{{ route('diskusi.create') }}" class="btn btn-discussion">
                <i class="fas fa-plus me-2"></i>Create New Topic
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('diskusi.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="Search topics..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="kategori">
                                <option value="">All Categories</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="resolved">
                                <option value="">All Status</option>
                                <option value="true" {{ request('resolved') == 'true' ? 'selected' : '' }}>Resolved</option>
                                <option value="false" {{ request('resolved') == 'false' ? 'selected' : '' }}>Unresolved</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-discussion w-100">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if($diskusiTopiks->count() > 0)
            @foreach($diskusiTopiks as $topic)
                <div class="card topic-item mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title">
                                    <a href="{{ route('diskusi.show', $topic->id) }}" class="text-decoration-none">
                                        {{ $topic->judul }}
                                    </a>
                                    @if($topic->is_resolved)
                                        <span class="badge resolved-badge ms-2">Resolved</span>
                                    @else
                                        <span class="badge unresolved-badge ms-2">Unresolved</span>
                                    @endif
                                    @if($topic->modul)
                                        <span class="badge bg-primary ms-2">Module: {{ $topic->modul->judul }}</span>
                                    @endif
                                </h5>
                                <p class="card-text text-muted">
                                    {{ Str::limit(strip_tags($topic->konten), 150) }}
                                </p>
                                <div class="d-flex align-items-center text-muted">
                                    <span class="me-3">
                                        @if($topic->user->profile_picture)
                                            <img src="{{ asset('storage/' . $topic->user->profile_picture) }}" alt="{{ $topic->user->name }}" class="user-avatar me-1">
                                        @else
                                            <i class="fas fa-user me-1"></i>
                                        @endif
                                        {{ $topic->user->name }}
                                    </span>
                                    <span class="me-3">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $topic->created_at->diffForHumans() }}
                                    </span>
                                    @if($topic->kategori)
                                        <span class="me-3">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $topic->kategori->nama }}
                                        </span>
                                    @endif
                                    @if($topic->modul)
                                        <span class="me-3">
                                            <i class="fas fa-book me-1"></i>
                                            {{ $topic->modul->kursus->judul }}
                                        </span>
                                    @endif
                                    <span class="me-3">
                                        <i class="fas fa-comments me-1"></i>
                                        {{ $topic->jumlah_komentar }} comments
                                    </span>
                                    <span>
                                        <i class="fas fa-thumbs-up me-1"></i>
                                        {{ $topic->jumlah_like }} likes
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('diskusi.show', $topic->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Topic
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center">
                {{ $diskusiTopiks->links() }}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h4>No discussion topics found</h4>
                    <p class="text-muted">Be the first to start a discussion!</p>
                    <a href="{{ route('diskusi.create') }}" class="btn btn-discussion">
                        <i class="fas fa-plus me-2"></i>Create New Topic
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection