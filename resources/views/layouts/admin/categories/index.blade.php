@extends('layouts.admin.app')

@section('title', 'Admin - Categories Management')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Categories Management</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Categories</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Add New Category
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Courses</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->nama }}</td>
                                        <td>{{ Str::limit($category->deskripsi, 50) }}</td>
                                        <td>{{ $category->kursus->count() }}</td>
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category? This will fail if there are courses using this category.')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>1</td>
                                    <td>Programming</td>
                                    <td>Courses related to software development</td>
                                    <td>12</td>
                                    <td>2025-01-15</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Data Science</td>
                                    <td>Courses related to data analysis and machine learning</td>
                                    <td>8</td>
                                    <td>2025-02-20</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($categories))
                    <div class="d-flex justify-content-center">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection