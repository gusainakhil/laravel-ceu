@extends('admin.layouts.app')

@section('title', $mode === 'add' ? 'Add Coupon' : 'Edit Coupon')

@section('content')
<form method="POST" action="{{ $mode === 'add' ? route('admin.coupon.store') : route('admin.coupon.update', $coupon->id) }}">
    @csrf

    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">{{ $mode === 'add' ? 'Add Coupon' : 'Edit Coupon' }}</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">
                        <i class="icofont-save me-2"></i>{{ $mode === 'add' ? 'Save' : 'Update' }}
                    </button>
                    <a href="{{ route('admin.page', 'coupons-list') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">Cancel</a>
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
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Coupon Details</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Coupon Code</label>
                            <input type="text" name="code" class="form-control text-uppercase" value="{{ old('code', $coupon->code) }}" placeholder="SAVE20" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Discount Type</label>
                            <select name="discount_type" class="form-select" required>
                                <option value="percentage" {{ old('discount_type', $coupon->discount_type ?: 'percentage') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('discount_type', $coupon->discount_type) === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" value="{{ old('discount_value', $coupon->discount_value) }}" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Max Uses</label>
                            <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses', $coupon->max_uses) }}" min="1" placeholder="Unlimited">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Minimum Order Amount</label>
                            <input type="number" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" min="0" step="0.01" placeholder="No minimum">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Maximum Discount Amount</label>
                            <input type="number" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" min="0" step="0.01" placeholder="No cap">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Validity & Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Valid From</label>
                        <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from', $coupon->valid_from ? $coupon->valid_from->format('Y-m-d') : '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Valid Until</label>
                        <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until', $coupon->valid_until ? $coupon->valid_until->format('Y-m-d') : '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ old('status', $mode === 'add' ? '1' : ($coupon->status ? '1' : '0')) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $mode === 'add' ? '1' : ($coupon->status ? '1' : '0')) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @if($mode === 'edit')
                        <div class="alert alert-info mb-0">
                            Used {{ $coupon->used_count }} time{{ $coupon->used_count == 1 ? '' : 's' }}.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
