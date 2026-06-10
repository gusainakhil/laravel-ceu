@extends('admin.layouts.app')

@section('title', $mode === 'add' ? 'Add Subscription Plan' : 'Edit Subscription Plan')

@section('content')
<form method="POST" action="{{ $mode === 'add' ? route('admin.subscription-plans.store') : route('admin.subscription-plans.update', $plan->id) }}">
    @csrf

    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">{{ $mode === 'add' ? 'Add Subscription Plan' : 'Edit Subscription Plan' }}</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">
                        <i class="icofont-save me-2"></i>{{ $mode === 'add' ? 'Save' : 'Update' }}
                    </button>
                    <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">Cancel</a>
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
                    <h6 class="m-0 fw-bold">Plan Details</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Plan Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $plan->slug) }}" placeholder="Auto generated if empty">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $plan->description) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Price</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $plan->price) }}" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Currency</label>
                            <input type="text" name="currency" class="form-control text-uppercase" value="{{ old('currency', $plan->currency ?: 'USD') }}" maxlength="3" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $plan->sort_order ?: 0) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Duration Days</label>
                            <input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', $plan->duration_days ?: 30) }}" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Free Extra Days</label>
                            <input type="number" name="free_extra_days" class="form-control" value="{{ old('free_extra_days', $plan->free_extra_days ?: 0) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Max Course Access</label>
                            <input type="number" name="max_course_access" class="form-control" value="{{ old('max_course_access', $plan->max_course_access) }}" min="1" placeholder="Unlimited">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Feature Matrix</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($features as $feature)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="hidden" name="features[{{ $feature->id }}]" value="0">
                                <input class="form-check-input" type="checkbox" name="features[{{ $feature->id }}]" id="feature{{ $feature->id }}" value="1" {{ old('features.' . $feature->id, $featureValues[$feature->id] ?? '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="feature{{ $feature->id }}">{{ $feature->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Access & Status</h6>
                </div>
                <div class="card-body">
                    @foreach([
                        'access_all_live_webinars' => 'All Live Webinars',
                        'access_all_recordings' => 'All Recordings',
                        'access_all_transcripts' => 'All Transcripts',
                        'priority_support' => 'Priority Support',
                        'is_popular' => 'Mark Popular',
                    ] as $field => $label)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1" {{ old($field, $plan->{$field}) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="{{ $field }}">{{ $label }}</label>
                    </div>
                    @endforeach
                    <div class="mt-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['active', 'inactive', 'archived'] as $status)
                                <option value="{{ $status }}" {{ old('status', $plan->status ?: 'active') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Industries</h6>
                </div>
                <div class="card-body" style="max-height: 220px; overflow: auto;">
                    @foreach($industries as $industry)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="industries[]" id="industry{{ $industry->id }}" value="{{ $industry->id }}" {{ in_array($industry->id, old('industries', $selectedIndustries)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="industry{{ $industry->id }}">{{ $industry->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Specific Courses</h6>
                </div>
                <div class="card-body" style="max-height: 320px; overflow: auto;">
                    <small class="text-muted d-block mb-3">Leave empty to allow all subscription-enabled courses, or filter by selected industries.</small>
                    @foreach($courses as $course)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="courses[]" id="course{{ $course->id }}" value="{{ $course->id }}" {{ in_array($course->id, old('courses', $selectedCourses)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="course{{ $course->id }}">{{ $course->title }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
