@extends('diskusi.app')

@section('title', $diskusiTopik->judul)

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('diskusi.index') }}">Discussions</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $diskusiTopik->judul }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card discussion-card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ $diskusiTopik->judul }}</h2>
                    @if($diskusiTopik->is_resolved)
                        <span class="badge bg-success">Resolved</span>
                    @else
                        <span class="badge bg-warning">Unresolved</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        </div>
                        <div>
                            <strong>{{ $diskusiTopik->user->name }}</strong>
                            <div class="text-muted small">
                                {{ $diskusiTopik->created_at->diffForHumans() }}
                                @if($diskusiTopik->kategori)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-tag me-1"></i>{{ $diskusiTopik->kategori->nama }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::id() == $diskusiTopik->user_id || Auth::user()->peran == 'Admin')
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="topicActions" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="topicActions">
                                @if(Auth::id() == $diskusiTopik->user_id)
                                    <li><a class="dropdown-item" href="{{ route('diskusi.edit', $diskusiTopik->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                @endif
                                @if(Auth::id() == $diskusiTopik->user_id || Auth::user()->peran == 'Admin')
                                    <li>
                                        <form action="{{ route('diskusi.destroy', $diskusiTopik->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                @endif
                                @if(!$diskusiTopik->is_resolved && Auth::id() == $diskusiTopik->user_id)
                                    <li>
                                        <form action="{{ route('diskusi.resolve', $diskusiTopik->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-check-circle me-2"></i>Mark as Resolved
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    {!! nl2br(e($diskusiTopik->konten)) !!}
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <button class="btn btn-sm btn-outline-primary like-topic" data-topic-id="{{ $diskusiTopik->id }}">
                            <i class="fas fa-thumbs-up me-1"></i>
                            <span class="like-count">{{ $diskusiTopik->jumlah_like }}</span> Likes
                        </button>
                    </div>
                    <div class="text-muted">
                        <i class="fas fa-comments me-1"></i>
                        {{ $diskusiTopik->jumlah_komentar }} comments
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h3 class="mb-4">Comments ({{ $diskusiTopik->jumlah_komentar }})</h3>
        
        <!-- Add Comment Form -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('diskusi.comments.store', $diskusiTopik->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="konten" class="form-label">Add a comment</label>
                        <textarea class="form-control" id="konten" name="konten" rows="3" required placeholder="Share your thoughts..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-discussion">
                        <i class="fas fa-paper-plane me-2"></i>Post Comment
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Comments List -->
        @if($komentars->count() > 0)
            @foreach($komentars as $komentar)
                <div class="card comment-item mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-user-circle fa-lg text-muted"></i>
                                </div>
                                <div>
                                    <strong>{{ $komentar->user->name }}</strong>
                                    <div class="text-muted small">{{ $komentar->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            
                            @if(Auth::id() == $komentar->user_id || Auth::user()->peran == 'Admin')
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="commentActions{{ $komentar->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="commentActions{{ $komentar->id }}">
                                        @if(Auth::id() == $komentar->user_id)
                                            <li><a class="dropdown-item" href="{{ route('diskusi.comments.edit', $komentar->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        @endif
                                        @if(Auth::id() == $komentar->user_id || Auth::user()->peran == 'Admin')
                                            <li>
                                                <form action="{{ route('diskusi.comments.destroy', $komentar->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('diskusi.comments.store', $diskusiTopik->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-reply me-2"></i>Reply
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <form action="{{ route('diskusi.comments.store', $diskusiTopik->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-reply me-1"></i>Reply
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="mt-3">
                            {!! nl2br(e($komentar->konten)) !!}
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <button class="btn btn-sm btn-outline-primary like-comment" data-comment-id="{{ $komentar->id }}">
                                    <i class="fas fa-thumbs-up me-1"></i>
                                    <span class="like-count">{{ $komentar->jumlah_like }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Replies -->
                @if($komentar->replies->count() > 0)
                    @foreach($komentar->replies as $reply)
                        <div class="card comment-item mb-2 ms-4 border-0 shadow-sm">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="fas fa-user-circle text-muted"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $reply->user->name }}</strong>
                                            <div class="text-muted small">{{ $reply->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    
                                    @if(Auth::id() == $reply->user_id || Auth::user()->peran == 'Admin')
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="replyActions{{ $reply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="replyActions{{ $reply->id }}">
                                                @if(Auth::id() == $reply->user_id)
                                                    <li><a class="dropdown-item" href="{{ route('diskusi.comments.edit', $reply->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                @endif
                                                @if(Auth::id() == $reply->user_id || Auth::user()->peran == 'Admin')
                                                    <li>
                                                        <form action="{{ route('diskusi.comments.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reply?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-2">
                                    {!! nl2br(e($reply->konten)) !!}
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary like-comment" data-comment-id="{{ $reply->id }}">
                                            <i class="fas fa-thumbs-up me-1"></i>
                                            <span class="like-count">{{ $reply->jumlah_like }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                    <p class="mb-0">No comments yet. Be the first to comment!</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Like topic functionality
    document.querySelectorAll('.like-topic').forEach(button => {
        button.addEventListener('click', function() {
            const topicId = this.getAttribute('data-topic-id');
            const likeCountElement = this.querySelector('.like-count');
            
            fetch(`/diskusi/${topicId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                likeCountElement.textContent = data.like_count;
                const icon = this.querySelector('i');
                if (data.liked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
    
    // Like comment functionality
    document.querySelectorAll('.like-comment').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const likeCountElement = this.querySelector('.like-count');
            
            fetch(`/diskusi/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                likeCountElement.textContent = data.like_count;
                const icon = this.querySelector('i');
                if (data.liked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection