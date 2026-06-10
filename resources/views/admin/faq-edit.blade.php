@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
<form method="POST" action="{{ route('admin.faq.update', $faq->id) }}">
    @csrf

    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Edit FAQ</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">
                        <i class="icofont-save me-2"></i>Update
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
                    <h6 class="m-0 fw-bold">FAQ Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">General</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $faq->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order) }}" min="0">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ old('status', $faq->status ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $faq->status ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Question & Answer</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Question</label>
                        <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question) }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Answer</label>
                        <textarea name="answer" class="form-control" rows="9" required>{{ old('answer', $faq->answer) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
