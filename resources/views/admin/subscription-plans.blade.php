@extends('admin.layouts.app')

@section('title', 'Subscription Plans')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Subscription Plans</h3>
            <a href="{{ route('admin.subscription-plans.add') }}" class="btn btn-primary btn-set-task w-sm-100 py-2 px-4 text-uppercase fw-bold">
                <i class="icofont-plus me-2"></i>Add Plan
            </a>
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
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Features</th>
                            <th>Courses</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>
                                <span class="fw-bold">{{ $plan->name }}</span>
                                @if($plan->is_popular)
                                    <span class="badge bg-primary ms-1">Popular</span>
                                @endif
                                <div class="text-muted small">{{ $plan->slug }}</div>
                            </td>
                            <td>${{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->duration_days + $plan->free_extra_days }} days</td>
                            <td>{{ $plan->features_count }}</td>
                            <td>{{ $plan->courses_count ?: 'All mapped' }}</td>
                            <td>
                                <span class="badge {{ $plan->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($plan->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="icofont-ui-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#myProjectTable').addClass('nowrap').dataTable({ responsive: true });
    });
</script>
@endsection
