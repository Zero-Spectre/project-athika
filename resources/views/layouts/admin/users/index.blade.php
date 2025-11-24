@extends('layouts.admin.app')

@section('title', 'Admin - Users Management')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Users Management</h1>
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
                <h5 class="mb-0">All Users</h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Add New User
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->peran == 'Admin')
                                                <span class="badge bg-primary">Admin</span>
                                            @elseif($user->peran == 'Instruktur')
                                                <span class="badge bg-success">Instructor</span>
                                            @else
                                                <span class="badge bg-warning">Participant</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td><span class="badge bg-primary">Admin</span></td>
                                    <td>2025-01-15</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Sarah Johnson</td>
                                    <td>sarah@example.com</td>
                                    <td><span class="badge bg-success">Instructor</span></td>
                                    <td>2025-02-20</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Michael Chen</td>
                                    <td>michael@example.com</td>
                                    <td><span class="badge bg-warning">Participant</span></td>
                                    <td>2025-03-10</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($users))
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection