@extends('layouts.admin.app')

@section('title', 'Admin - Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">System Settings</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">General Settings</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="siteName" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="siteName" value="{{ config('app.name') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="siteDescription" class="form-label">Site Description</label>
                        <textarea class="form-control" id="siteDescription" rows="3">Online learning platform for professional development</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">Admin Email</label>
                        <input type="email" class="form-control" id="adminEmail" value="admin@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="timezone" class="form-label">Timezone</label>
                        <select class="form-select" id="timezone">
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">Eastern Time</option>
                            <option value="America/Chicago">Central Time</option>
                            <option value="America/Denver">Mountain Time</option>
                            <option value="America/Los_Angeles">Pacific Time</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Email Settings</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="mailDriver" class="form-label">Mail Driver</label>
                        <select class="form-select" id="mailDriver">
                            <option value="smtp">SMTP</option>
                            <option value="mailgun">Mailgun</option>
                            <option value="ses">Amazon SES</option>
                            <option value="postmark">Postmark</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mailHost" class="form-label">Mail Host</label>
                        <input type="text" class="form-control" id="mailHost" value="smtp.example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="mailPort" class="form-label">Mail Port</label>
                        <input type="number" class="form-control" id="mailPort" value="587">
                    </div>
                    
                    <div class="mb-3">
                        <label for="mailUsername" class="form-label">Mail Username</label>
                        <input type="text" class="form-control" id="mailUsername" value="user@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label for="mailPassword" class="form-label">Mail Password</label>
                        <input type="password" class="form-control" id="mailPassword" value="password">
                    </div>
                    
                    <div class="mb-3">
                        <label for="mailEncryption" class="form-label">Mail Encryption</label>
                        <select class="form-select" id="mailEncryption">
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Email Settings</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">System Information</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>PHP Version:</strong> 8.1.0
                    </li>
                    <li class="list-group-item">
                        <strong>Laravel Version:</strong> 10.0.0
                    </li>
                    <li class="list-group-item">
                        <strong>Database:</strong> MySQL 8.0
                    </li>
                    <li class="list-group-item">
                        <strong>Cache Driver:</strong> Redis
                    </li>
                    <li class="list-group-item">
                        <strong>Session Driver:</strong> Database
                    </li>
                    <li class="list-group-item">
                        <strong>Queue Driver:</strong> Redis
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Maintenance</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" type="button">
                        <i class="fas fa-sync-alt me-1"></i>Clear Cache
                    </button>
                    <button class="btn btn-outline-primary" type="button">
                        <i class="fas fa-database me-1"></i>Clear Database Cache
                    </button>
                    <button class="btn btn-outline-primary" type="button">
                        <i class="fas fa-route me-1"></i>Clear Route Cache
                    </button>
                    <button class="btn btn-outline-primary" type="button">
                        <i class="fas fa-file-code me-1"></i>Clear View Cache
                    </button>
                    <button class="btn btn-outline-warning" type="button">
                        <i class="fas fa-exclamation-triangle me-1"></i>Enable Maintenance Mode
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection