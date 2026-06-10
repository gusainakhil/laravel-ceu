<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            border-bottom: 3px solid #10b981;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #10b981;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 12px 15px;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        th {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }
        
        td {
            border: 1px solid #e5e7eb;
            padding: 10px;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .summary-section {
            background-color: #f0fdf4;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #d1fae5;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .summary-row strong {
            font-weight: bold;
        }
        
        .total-row {
            border-top: 2px solid #10b981;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #065f46;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            margin-right: 5px;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-info {
            background-color: #dbeafe;
            color: #0c4a6e;
        }
        
        .customer-info {
            font-size: 12px;
            margin-top: 10px;
        }
        
        .customer-info p {
            margin-bottom: 5px;
        }
        
        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        
        .row {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .col-6 {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Order Invoice</h1>
            <div class="header-info">
                <div>
                    <strong>Order Number:</strong> {{ $order->order_number }}<br>
                    <strong>Order Date:</strong> {{ optional($order->created_at)->format('M d, Y') }}<br>
                    <strong>Order Time:</strong> {{ optional($order->created_at)->format('h:i A') }}
                </div>
                <div>
                    <strong>Order Status:</strong> <span class="badge badge-info">{{ ucfirst($order->status) }}</span><br>
                    <strong>Payment Status:</strong> <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="section">
            <div class="section-title">Order Items</div>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->title }}</strong><br>
                            @if($item->course)
                                <small style="color: #666;">Course: {{ $item->course->title }}</small>
                            @elseif($item->subscriptionPlan)
                                <small style="color: #666;">Plan: {{ $item->subscriptionPlan->name }}</small>
                            @endif
                            @if($item->description)
                                <br><small style="color: #999;">{{ $item->description }}</small>
                            @endif
                        </td>
                        <td>{{ ucfirst($item->item_type) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format((float) $item->unit_price, 2) }}</td>
                        <td class="text-right"><strong>${{ number_format((float) $item->total_price, 2) }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No order items found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Summary & Customer Info -->
        <div class="row">
            <!-- Summary -->
            <div class="col-6">
                <div class="section-title">Order Summary</div>
                <div class="summary-section">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format((float) $order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_total > 0)
                    <div class="summary-row">
                        <span>Discount</span>
                        <span>-${{ number_format((float) $order->discount_total, 2) }}</span>
                    </div>
                    @endif
                    @if($order->tax_total > 0)
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>${{ number_format((float) $order->tax_total, 2) }}</span>
                    </div>
                    @endif
                    <div class="summary-row total-row">
                        <span>Total Amount</span>
                        <span>{{ $order->currency }} {{ number_format((float) $order->grand_total, 2) }}</span>
                    </div>
                    @if($order->coupon)
                    <div class="summary-row" style="margin-top: 10px;">
                        <span>Coupon Applied</span>
                        <span>{{ $order->coupon->code }}</span>
                    </div>
                    @endif
                    @if($order->payment_gateway)
                    <div class="summary-row">
                        <span>Payment Gateway</span>
                        <span>{{ ucfirst($order->payment_gateway) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <div class="col-6">
                <div class="section-title">Customer Information</div>
                <div class="customer-info">
                    @if($order->user)
                        <p><strong>{{ $order->user->name }}</strong></p>
                        <p>{{ $order->user->email }}</p>
                        @if($order->user->phone)
                        <p>{{ $order->user->phone }}</p>
                        @endif
                        @if($order->user->company_name)
                        <p><strong>Company:</strong> {{ $order->user->company_name }}</p>
                        @endif
                    @else
                        <p><strong>{{ $order->guest_name ?: 'Guest Customer' }}</strong></p>
                        <p>{{ $order->guest_email ?: 'No email provided' }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Attendees -->
        @if($order->attendees->count())
        <div class="section">
            <div class="section-title">Attendees</div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Job Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->attendees as $attendee)
                    <tr>
                        <td><strong>{{ $attendee->name }}</strong></td>
                        <td>{{ $attendee->email }}</td>
                        <td>{{ $attendee->phone ?: 'N/A' }}</td>
                        <td>{{ $attendee->job_title ?: 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Payment Transactions -->
        @if($order->transactions->count())
        <div class="section">
            <div class="section-title">Payment Transactions</div>
            <table>
                <thead>
                    <tr>
                        <th>Gateway</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th class="text-right">Amount</th>
                        <th>Paid Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->transactions as $transaction)
                    <tr>
                        <td>{{ ucfirst($transaction->gateway_slug) }}</td>
                        <td><small>{{ $transaction->transaction_id ?: 'N/A' }}</small></td>
                        <td><span class="badge {{ $transaction->status === 'succeeded' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($transaction->status) }}</span></td>
                        <td class="text-right">{{ $transaction->currency }} {{ number_format((float) $transaction->amount, 2) }}</td>
                        <td>{{ $transaction->paid_at ? $transaction->paid_at->format('M d, Y') : 'Pending' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Granted Access -->
        @if($courseAccesses->count())
        <div class="section">
            <div class="section-title">Granted Course Access</div>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Access Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseAccesses as $access)
                    <tr>
                        <td><strong>{{ optional($access->course)->title ?: 'Course Access' }}</strong></td>
                        <td>{{ ucfirst($access->access_type) }}</td>
                        <td><span class="badge badge-success">{{ ucfirst($access->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This is an official order invoice from CEU Trainers. For inquiries, please contact support.</p>
            <p>Generated on {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>
