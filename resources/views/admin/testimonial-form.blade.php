@extends('admin.layouts.app')

@section('title', $mode === 'add' ? 'Add Testimonial' : 'Edit Testimonial')

@section('content')
<form method="POST" action="{{ $mode === 'add' ? route('admin.testimonials.store') : route('admin.testimonials.update', $testimonial->id) }}">
    @csrf

    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">{{ $mode === 'add' ? 'Add Testimonial' : 'Edit Testimonial' }}</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">
                        <i class="icofont-save me-2"></i>{{ $mode === 'add' ? 'Save' : 'Update' }}
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">Cancel</a>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row g-3 mb-3">
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Testimonial Content</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Designation</label>
                            <input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}" placeholder="HR Manager">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Message</label>
                            <textarea name="message" class="form-control" rows="7" required>{{ old('message', $testimonial->message) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Display Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rating</label>
                        <select name="rating" class="form-select" required>
                            @for($rating = 5; $rating >= 1; $rating--)
                                <option value="{{ $rating }}" {{ old('rating', $testimonial->rating ?: 5) == $rating ? 'selected' : '' }}>{{ $rating }} / 5</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order ?: 0) }}" min="0">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ old('status', $mode === 'add' ? '1' : ($testimonial->status ? '1' : '0')) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $mode === 'add' ? '1' : ($testimonial->status ? '1' : '0')) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
