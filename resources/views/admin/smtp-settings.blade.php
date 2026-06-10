@extends('admin.layouts.app')

@section('title', 'SMTP Setup')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">SMTP Configuration Settings</h3>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-3 mb-3">
    <div class="col-xl-8 col-lg-10 col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('admin.smtp.save') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Mail Driver</label>
                            <input type="text" name="mailer" class="form-control" value="{{ $smtp->mailer ?? 'smtp' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mail Encryption</label>
                            <select name="encryption" class="form-select">
                                <option value="tls" {{ ($smtp->encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($smtp->encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="none" {{ ($smtp->encryption ?? '') == 'none' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">SMTP Host</label>
                            <input type="text" name="host" class="form-control" value="{{ $smtp->host ?? '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SMTP Port</label>
                            <input type="number" name="port" class="form-control" value="{{ $smtp->port ?? 587 }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $smtp->username ?? '' }}" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SMTP Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••••••" autocomplete="new-password">
                            <small class="text-muted">Leave blank to keep current password.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Mail Address</label>
                            <input type="email" name="from_address" class="form-control" value="{{ $smtp->from_address ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Name</label>
                            <input type="text" name="from_name" class="form-control" value="{{ $smtp->from_name ?? '' }}" required>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary text-uppercase px-4">Save Configuration</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
