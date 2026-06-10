@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Testimonials</h3>
            <a href="{{ route('admin.testimonials.add') }}" class="btn btn-primary btn-set-task w-sm-100 py-2 px-4 text-uppercase fw-bold">
                <i class="icofont-plus me-2"></i>Add Testimonial
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
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Message</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td><span class="fw-bold">{{ $testimonial->name }}</span></td>
                            <td>{{ $testimonial->designation ?: 'N/A' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($testimonial->message, 90) }}</td>
                            <td>{{ $testimonial->rating }}/5</td>
                            <td>
                                <span class="badge {{ $testimonial->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $testimonial->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-outline-primary">
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
