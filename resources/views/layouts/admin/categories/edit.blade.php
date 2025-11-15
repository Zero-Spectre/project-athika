@extends('layouts.admin.app')

@section('title', 'Edit Category')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Edit Category</h1>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Categories
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Category Information</h5>
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

                <form action="{{ route('admin.categories.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection