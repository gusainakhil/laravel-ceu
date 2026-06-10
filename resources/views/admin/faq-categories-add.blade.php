@extends('admin.layouts.app')

@section('title', 'Add FAQ Category')

@section('content')
<form method="POST" action="{{ route('admin.faq-category.store') }}">
    @csrf

    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Add FAQ Category</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">
                        <i class="icofont-save me-2"></i>Save
                    </button>
                    <a href="{{ route('admin.page', 'faq-categorie-list') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">Cancel</a>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="row g-3 mb-3">
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Category Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="General Questions" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">First FAQ Question</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Question</label>
                        <input type="text" name="question" class="form-control" value="{{ old('question') }}" placeholder="Enter FAQ question">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Answer</label>
                        <textarea name="answer" class="form-control" rows="8" placeholder="Enter FAQ answer">{{ old('answer') }}</textarea>
                        <small class="text-muted d-block mt-2">Question and answer are optional. You can save only the category.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
