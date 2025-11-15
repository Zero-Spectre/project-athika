@extends('diskusi.app')

@section('title', 'Edit Comment')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Edit Comment</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('diskusi.comments.update', $diskusiKomentar->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="konten" class="form-label">Comment Content</label>
                        <textarea class="form-control" id="konten" name="konten" rows="5" required>{{ old('konten', $diskusiKomentar->konten) }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('diskusi.show', $diskusiKomentar->diskusi_topik_id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Topic
                        </a>
                        <button type="submit" class="btn btn-discussion">
                            <i class="fas fa-save me-2"></i>Update Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection