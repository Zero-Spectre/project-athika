@extends('layouts.instruktur.app')

@section('title', 'Create Course')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Create New Course</h1>
            <a href="{{ route('instruktur.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Courses
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Course Information</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('instruktur.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Course Title</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Category</label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                        <div class="form-text">Upload a course thumbnail (optional). JPG, PNG, GIF up to 2MB.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status_publish" class="form-label">Status</label>
                        <select class="form-select" id="status_publish" name="status_publish" required>
                            <option value="Draft" {{ old('status_publish') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Published" {{ old('status_publish') == 'Published' ? 'selected' : '' }}>Published</option>
                            <option value="Rejected" {{ old('status_publish') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('instruktur.courses.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection