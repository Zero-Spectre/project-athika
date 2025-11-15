@extends('diskusi.app')

@section('title', 'Create New Topic')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Create New Discussion Topic</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('diskusi.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Topic Title</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                        @if(isset($modul))
                            <div class="form-text">Creating discussion for module: {{ $modul->judul }}</div>
                            <input type="hidden" name="modul_id" value="{{ $modul->id }}">
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Category (Optional)</label>
                        <select class="form-select" id="kategori_id" name="kategori_id">
                            <option value="">Select a category</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if(isset($modul))
                        <div class="mb-3">
                            <label class="form-label">Related Module</label>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $modul->judul }}</h5>
                                    <p class="card-text">{{ $modul->kursus->judul }}</p>
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $modul->tipe_materi)) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="konten" class="form-label">Content</label>
                        <textarea class="form-control" id="konten" name="konten" rows="10" required>{{ old('konten') }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('diskusi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Discussions
                        </a>
                        <button type="submit" class="btn btn-discussion">
                            <i class="fas fa-paper-plane me-2"></i>Create Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection