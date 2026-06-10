@extends('admin.layouts.app')

@section('title', 'Payment Settings')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Payment Gateways Configuration</h3>
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
    @foreach($gateways as $gateway)
    <div class="col-xl-6 col-lg-12">
        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="mb-0 fw-bold">{{ $gateway->name }} Gateway ({{ ucfirst($gateway->mode) }} Mode)</h6>
                <span class="badge {{ $gateway->status ? 'bg-success' : 'bg-danger' }}">
                    {{ $gateway->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.gateway.save', $gateway->id) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Gateway Mode</label>
                            <select name="mode" class="form-select">
                                <option value="sandbox" {{ $gateway->mode == 'sandbox' ? 'selected' : '' }}>Sandbox / Testing</option>
                                <option value="live" {{ $gateway->mode == 'live' ? 'selected' : '' }}>Live / Production</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gateway Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ $gateway->status ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ !$gateway->status ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        @if($gateway->slug == 'stripe')
                        <div class="col-12">
                            <label class="form-label">Publishable Key</label>
                            <input type="text" name="settings[publishable_key]" class="form-control" value="{{ $gateway->getSetting('publishable_key') ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Secret Key</label>
                            <input type="password" name="settings[secret_key]" class="form-control" placeholder="••••••••••••••••••••••••••••••••">
                            <small class="text-muted">Leave blank to keep current secret key.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Webhook Secret</label>
                            <input type="password" name="settings[webhook_secret]" class="form-control" placeholder="••••••••••••••••••••••••••••••••">
                            <small class="text-muted">Leave blank to keep current webhook secret.</small>
                        </div>
                        @elseif($gateway->slug == 'paypal')
                        <div class="col-12">
                            <label class="form-label">Client ID</label>
                            <input type="text" name="settings[client_id]" class="form-control" value="{{ $gateway->getSetting('client_id') ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Client Secret</label>
                            <input type="password" name="settings[client_secret]" class="form-control" placeholder="••••••••••••••••••••••••••••••••">
                            <small class="text-muted">Leave blank to keep current client secret.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Webhook ID</label>
                            <input type="text" name="settings[webhook_id]" class="form-control" value="{{ $gateway->getSetting('webhook_id') ?? '' }}">
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label">Currency</label>
                            <input type="text" name="settings[currency]" class="form-control" value="{{ $gateway->getSetting('currency') ?? 'USD' }}" required maxlength="3">
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary text-uppercase px-4">Save {{ $gateway->name }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
