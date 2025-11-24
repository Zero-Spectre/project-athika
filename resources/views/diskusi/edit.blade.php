@extends('diskusi.app')

@section('title', 'Edit Topic: ' . $diskusiTopik->judul)

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Edit Discussion Topic</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('diskusi.update', $diskusiTopik->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Topic Title</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $diskusiTopik->judul) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Category (Optional)</label>
                        <select class="form-select" id="kategori_id" name="kategori_id">
                            <option value="">Select a category</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $diskusiTopik->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="konten" class="form-label">Content</label>
                        <textarea class="form-control" id="konten" name="konten" rows="10" required>{{ old('konten', $diskusiTopik->konten) }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('diskusi.show', $diskusiTopik->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Topic
                        </a>
                        <button type="submit" class="btn btn-discussion">
                            <i class="fas fa-save me-2"></i>Update Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection