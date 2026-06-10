@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('styles')
<style>
    .order-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .order-row:hover {
        background-color: #f0fdf4 !important;
    }
</style>
@endsection

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <div>
                <h3 class="fw-bold mb-0">Customer Details</h3>
                <span class="text-muted">{{ $customer->name }}</span>
            </div>
            <a href="{{ route('admin.page', 'customers') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-4 text-uppercase fw-bold">
                <i class="icofont-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-xl-4 col-lg-5">
        <div class="card mb-3">
            <div class="card-body text-center">
                <img class="avatar rounded mb-3" src="{{ $customer->avatar ?: asset('ceuadmin-assets/assets/images/profile_av.svg') }}" alt="" style="width: 90px; height: 90px;">
                <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                <div class="text-muted mb-3">{{ $customer->email }}</div>
                <span class="badge {{ $customer->status ? 'bg-success' : 'bg-secondary' }}">
                    {{ $customer->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="card-body border-top">
                <div class="mb-2"><strong>Phone:</strong> {{ $customer->phone ?: 'N/A' }}</div>
                <div class="mb-2"><strong>Company:</strong> {{ $customer->company_name ?: 'N/A' }}</div>
                <div class="mb-2"><strong>Job Title:</strong> {{ $customer->job_title ?: 'N/A' }}</div>
                <div class="mb-2"><strong>Joined:</strong> {{ $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A' }}</div>
                <div><strong>Last Login:</strong> {{ $customer->last_login_at ? $customer->last_login_at->format('M d, Y h:i A') : 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-xl-4">
            <div class="col">
                <div class="card">
                    <div class="card-body py-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">ORDERS</span>
                            <div class="fs-5 fw-bold">{{ $customer->orders_count }}</div>
                        </div>
                        <i class="icofont-shopping-cart fs-3 color-light-orange"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body py-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">TOTAL SPENT</span>
                            <div class="fs-5 fw-bold">${{ number_format($customer->orders_sum_grand_total ?? 0, 2) }}</div>
                        </div>
                        <i class="icofont-dollar fs-3 color-lightblue"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body py-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">SUBSCRIPTIONS</span>
                            <div class="fs-5 fw-bold">{{ $customer->subscriptions_count }}</div>
                        </div>
                        <i class="icofont-refresh fs-3 color-lavender-purple"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body py-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted">COURSE ACCESS</span>
                            <div class="fs-5 fw-bold">{{ $customer->course_accesses_count }}</div>
                        </div>
                        <i class="icofont-read-book fs-3 color-santa-fe"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Subscription Status</h6>
            </div>
            <div class="card-body">
                @if($activeSubscriptions->count())
                    @foreach($activeSubscriptions as $subscription)
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                        <div>
                            <div class="fw-bold">{{ $subscription->plan->name ?? 'Subscription Plan' }}</div>
                            <div class="text-muted small">
                                {{ $subscription->start_date ? $subscription->start_date->format('M d, Y') : 'N/A' }}
                                -
                                {{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}
                            </div>
                            <div class="text-muted small">Renewal: {{ $subscription->renewal_date ? $subscription->renewal_date->format('M d, Y') : 'N/A' }}</div>
                        </div>
                        <span class="badge bg-success">{{ ucfirst($subscription->status) }}</span>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-warning mb-0">No active subscription found for this customer.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-xl-8">
        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Orders</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->orders->sortByDesc('created_at') as $order)
                            <tr class="order-row" data-order-id="{{ $order->id }}">
                                <td><strong>{{ $order->order_number }}</strong><br><span class="text-muted small">{{ ucfirst($order->status ?? 'order') }}</span></td>
                                <td>
                                    @foreach($order->items as $item)
                                        <div>{{ $item->title }}</div>
                                        <span class="text-muted small">{{ $item->description ?: ucfirst($item->item_type ?? 'item') }}</span>
                                    @endforeach
                                </td>
                                <td>${{ number_format($order->grand_total, 2) }}</td>
                                <td>
                                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($order->payment_status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Addresses</h6>
            </div>
            <div class="card-body">
                @forelse($customer->addresses as $address)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-bold">{{ ucfirst($address->type ?? 'saved') }} Address</div>
                        <div>{{ $address->name ?: $customer->name }}</div>
                        <div class="text-muted">{{ $address->address_line_1 }}</div>
                        @if($address->address_line_2)
                            <div class="text-muted">{{ $address->address_line_2 }}</div>
                        @endif
                        <div class="text-muted">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</div>
                        <div class="text-muted">{{ $address->country }}</div>
                    </div>
                @empty
                    <div class="text-muted">No address saved.</div>
                @endforelse
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Course Access</h6>
            </div>
            <div class="card-body">
                @forelse($customer->courseAccesses as $access)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-bold">{{ $access->course->title ?? 'Course' }}</div>
                        <div class="text-muted small">{{ ucfirst($access->access_source ?? 'access') }} - {{ ucfirst($access->access_type ?? 'course') }}</div>
                        <span class="badge {{ $access->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($access->status ?? 'inactive') }}</span>
                    </div>
                @empty
                    <div class="text-muted">No course access found.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Make order rows clickable
    $('.order-row').on('click', function() {
        var orderId = $(this).data('order-id');
        if (orderId) {
            window.location.href = '/ceuadmin/orders/' + orderId;
        }
    });
});
</script>
@endsection
