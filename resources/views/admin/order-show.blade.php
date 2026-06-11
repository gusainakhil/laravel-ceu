@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('styles')
<style>
    @media print {
        * {
            margin: 0;
            padding: 0;
        }
        
        body {
            background: white !important;
            font-size: 13px;
            color: #333;
        }
        
        .btn, .sidebar, nav, .navbar, .breadcrumb, .no-print {
            display: none !important;
        }
        
        .row {
            page-break-inside: avoid;
        }
        
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            page-break-inside: avoid;
            margin-bottom: 15px;
        }
        
        .card-header {
            background-color: #10b981 !important;
            color: white !important;
            padding: 12px 15px !important;
            border-bottom: 2px solid #059669 !important;
        }
        
        .card-header h6 {
            color: white !important;
            margin: 0;
        }
        
        .card-body {
            padding: 12px 15px !important;
        }
        
        .table {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .table thead th {
            background-color: #f3f4f6 !important;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        
        .table tbody td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        .table tbody tr:nth-child(odd) {
            background-color: #f9fafb;
        }
        
        .badge {
            border: none !important;
            padding: 3px 8px !important;
            font-size: 11px !important;
        }
        
        .d-flex {
            display: flex;
        }
        
        .justify-content-between {
            justify-content: space-between;
        }
        
        .print-header {
            border-bottom: 3px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
            page-break-after: avoid;
        }
        
        .print-header h3 {
            font-size: 24px;
            color: #10b981;
            margin: 0 0 5px 0;
        }
        
        .print-header p {
            margin: 0;
            color: #666;
            font-size: 12px;
        }
        
        .col-lg-4, .col-lg-5, .col-xl-4, .col-xl-8, .col-lg-7 {
            float: left;
            page-break-inside: avoid;
        }
        
        .col-xl-8, .col-lg-7 {
            width: 65%;
            padding-right: 15px;
        }
        
        .col-xl-4, .col-lg-5 {
            width: 35%;
        }
        
        .g-3 {
            margin-bottom: 0;
        }
        
        @page {
            margin: 0.5in;
            size: A4;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    }
    
    .print-preview-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    }
    
    .print-preview-content {
        background-color: #fefefe;
        margin: 2% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 95%;
        height: 90vh;
        overflow-y: auto;
        border-radius: 5px;
    }
    
    .print-preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #10b981;
    }
    
    .print-preview-header h4 {
        margin: 0;
        color: #10b981;
    }
    
    .print-close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .print-close-btn:hover {
        color: #000;
    }
    
    .print-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <div>
                <h3 class="fw-bold mb-1">Order {{ $order->order_number }}</h3>
                <p class="text-muted mb-0">Placed {{ optional($order->created_at)->format('M d, Y h:i A') }}</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.order.pdf', $order->id) }}" target="_blank" class="btn btn-outline-success btn-set-task py-2 px-4 fw-bold">
                    <i class="icofont-file-document me-2"></i>Generate Invoice
                </a>
                <a href="{{ route('admin.page', 'order-list') }}" class="btn btn-secondary btn-set-task py-2 px-4 text-uppercase fw-bold">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-xl-8 col-lg-7">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Order Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Type</th>
                                <th>Option</th>
                                <th>Qty</th>
                                <th class="text-end">Unit</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                    @if($item->course)
                                        <div class="text-muted small">Course: {{ $item->course->title }}</div>
                                    @elseif($item->subscriptionPlan)
                                        <div class="text-muted small">Plan: {{ $item->subscriptionPlan->name }}</div>
                                    @endif
                                </td>
                                <td>{{ ucfirst($item->item_type) }}</td>
                                <td>{{ $item->description ?: 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format((float) $item->unit_price, 2) }}</td>
                                <td class="text-end"><strong>${{ number_format((float) $item->total_price, 2) }}</strong></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No order items found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Attendees</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Job Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->attendees as $attendee)
                            <tr>
                                <td><strong>{{ $attendee->name }}</strong></td>
                                <td>{{ $attendee->email }}</td>
                                <td>{{ $attendee->phone ?: 'N/A' }}</td>
                                <td>{{ $attendee->job_title ?: 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No attendees found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Payment Transactions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Gateway</th>
                                <th>Transaction</th>
                                <th>Gateway Payment</th>
                                <th>Status</th>
                                <th class="text-end">Amount</th>
                                <th>Paid At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->transactions as $transaction)
                            <tr>
                                <td>{{ ucfirst($transaction->gateway_slug) }}</td>
                                <td class="small">{{ $transaction->transaction_id ?: 'N/A' }}</td>
                                <td class="small">{{ $transaction->gateway_payment_id ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $transaction->status === 'succeeded' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $transaction->currency }} {{ number_format((float) $transaction->amount, 2) }}</td>
                                <td>{{ $transaction->paid_at ? $transaction->paid_at->format('M d, Y h:i A') : 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No payment transactions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Summary</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Order Status</span>
                    <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Payment Status</span>
                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Gateway</span>
                    <strong>{{ $order->payment_gateway ? ucfirst($order->payment_gateway) : 'N/A' }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <strong>${{ number_format((float) $order->subtotal, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Discount</span>
                    <strong>-${{ number_format((float) $order->discount_total, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax</span>
                    <strong>${{ number_format((float) $order->tax_total, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between fs-5">
                    <span>Total</span>
                    <strong>{{ $order->currency }} {{ number_format((float) $order->grand_total, 2) }}</strong>
                </div>
                @if($order->coupon)
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Coupon</span>
                        <strong>{{ $order->coupon->code }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Customer</h6>
            </div>
            <div class="card-body">
                @if($order->user)
                    <h6 class="fw-bold mb-1">{{ $order->user->name }}</h6>
                    <p class="mb-1">{{ $order->user->email }}</p>
                    <p class="mb-1">{{ $order->user->phone ?: 'No phone' }}</p>
                    <p class="mb-0 text-muted">{{ $order->user->company_name ?: 'No company' }}</p>
                    <a href="{{ route('admin.customer.show', $order->user->id) }}" class="btn btn-outline-primary btn-sm mt-3">View Customer</a>
                @else
                    <h6 class="fw-bold mb-1">{{ $order->guest_name ?: 'Guest Customer' }}</h6>
                    <p class="mb-0">{{ $order->guest_email ?: 'No email' }}</p>
                @endif
            </div>
        </div>

        @if($subscription)
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Subscription</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Plan</span>
                    <strong>{{ optional($subscription->plan)->name ?: 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Status</span>
                    <span class="badge bg-success">{{ ucfirst($subscription->status) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Auto Renew</span>
                    <strong>{{ $subscription->auto_renew ? 'Yes' : 'No' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Start</span>
                    <strong>{{ optional($subscription->start_date)->format('M d, Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>End</span>
                    <strong>{{ optional($subscription->end_date)->format('M d, Y') }}</strong>
                </div>
                <div class="small text-muted mt-3">
                    Gateway Subscription: {{ $subscription->gateway_subscription_id ?: 'N/A' }}
                </div>
            </div>
        </div>
        @endif

        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">Granted Access</h6>
            </div>
            <div class="card-body">
                @forelse($courseAccesses as $access)
                    <div class="mb-3">
                        <strong>{{ optional($access->course)->title ?: 'Course Access' }}</strong>
                        <div class="text-muted small">
                            {{ ucfirst($access->access_type) }} access · {{ ucfirst($access->status) }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No course access records found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Print Preview Modal -->
<div id="printModal" class="print-preview-modal">
    <div class="print-preview-content">
        <div class="print-preview-header">
            <h4><i class="icofont-print me-2"></i>Print Preview - Order {{ $order->order_number }}</h4>
            <span class="print-close-btn" onclick="closePrintModal()">&times;</span>
        </div>
        <div class="print-actions">
            <button class="btn btn-primary" onclick="executePrint()">
                <i class="icofont-print me-2"></i>Print Now
            </button>
            <button class="btn btn-secondary" onclick="closePrintModal()">
                <i class="icofont-close me-2"></i>Close
            </button>
        </div>
        <div id="printContent">
            <!-- Print content will be cloned here -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Print button click handler
    $('#printBtn').on('click', function(e) {
        e.preventDefault();
        openPrintPreview();
    });
});

function openPrintPreview() {
    // Clone the main content
    var content = $('.row.g-3').clone();
    
    // Create print header
    var header = `
        <div class="print-header">
            <h3>Order #{{ $order->order_number }}</h3>
            <p>Placed on {{ optional($order->created_at)->format('M d, Y h:i A') }}</p>
        </div>
    `;
    
    // Clear and populate the print content
    $('#printContent').html(header + content.html());
    
    // Show modal
    $('#printModal').show();
}

function closePrintModal() {
    $('#printModal').hide();
}

function executePrint() {
    // Hide modal buttons before printing
    $('.print-actions').hide();
    
    // Trigger print dialog
    window.print();
    
    // Show buttons again after print
    setTimeout(function() {
        $('.print-actions').show();
    }, 1000);
}

// Close modal when clicking outside of it
$(window).on('click', function(event) {
    var modal = $('#printModal')[0];
    if (event.target === modal) {
        closePrintModal();
    }
});

// Improve print layout
$(window).on('beforeprint', function() {
    $('body').css('overflow', 'hidden');
});

$(window).on('afterprint', function() {
    $('body').css('overflow', 'auto');
    closePrintModal();
});
</script>

@endsection
