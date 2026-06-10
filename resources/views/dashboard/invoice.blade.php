<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    
    <!-- CSS Vendor Assets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}" />
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            color: #334155;
            background-color: #f8fafc;
            padding: 40px 0;
            font-size: 14px;
        }

        .invoice-box {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 45px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
        }

        /* Top Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .logo img {
            max-height: 55px;
            width: auto;
        }

        .invoice-title {
            font-size: 48px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -1.5px;
            margin: 0;
            text-transform: uppercase;
        }

        /* Center Metadata Bar */
        .metadata-bar {
            background-color: #f8fafc;
            border-radius: 10px;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            border: 1px solid #f1f5f9;
        }

        .metadata-item {
            font-size: 13.5px;
            color: #64748b;
        }

        .metadata-item strong {
            color: #0f172a;
        }

        /* Recipient Columns */
        .recipient-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 40px;
        }

        .recipient-col {
            flex: 1;
        }

        .recipient-col h5 {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 12px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 6px;
        }

        .recipient-details {
            line-height: 1.6;
            color: #475569;
        }

        /* Items Table */
        .table-container {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 35px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.01);
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .invoice-table th {
            background-color: #f8fafc;
            font-weight: 700;
            font-size: 12px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .invoice-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
            font-size: 13.5px;
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Summary & Info Block */
        .summary-block {
            display: flex;
            justify-content: space-between;
            margin-bottom: 45px;
            gap: 40px;
        }

        .payment-info-box {
            flex: 1.2;
            background: #ffffff;
            border: 1px solid #f1f5f9;
            padding: 20px;
            border-radius: 12px;
        }

        .payment-info-box h6 {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .payment-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            line-height: 1.8;
            color: #475569;
            font-size: 13px;
        }

        .summary-calculations {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 14px;
        }

        .calc-row {
            display: flex;
            justify-content: space-between;
            color: #475569;
        }

        .calc-row.total {
            border-top: 2px solid #0f172a;
            padding-top: 12px;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Terms Box */
        .terms-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            background-color: #ffffff;
        }

        .terms-card h6 {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .terms-list {
            padding-left: 20px;
            margin: 0;
            font-size: 12px;
            color: #64748b;
            line-height: 1.7;
        }

        .terms-list li {
            margin-bottom: 10px;
        }

        .terms-list li:last-child {
            margin-bottom: 0;
        }

        /* Action Buttons */
        .action-container {
            max-width: 900px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-invoice {
            font-weight: 700;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-print {
            background-color: #1ab69d;
            border: none;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(26, 182, 157, 0.15);
        }

        .btn-print:hover {
            background-color: #0d9488;
            transform: translateY(-1px);
        }

        .btn-back {
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #475569;
        }

        .btn-back:hover {
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* Printing Adjustments */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }

            .invoice-box {
                box-shadow: none;
                border: none;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Top Action Row -->
    <div class="action-container no-print">
        <a href="{{ route('dashboard') }}" class="btn-invoice btn-back">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
        <button onclick="window.print()" class="btn-invoice btn-print">
            <i class="fa fa-print"></i> Print / Save Invoice
        </button>
    </div>

    <!-- Main Print Box -->
    <div class="invoice-box">
        <!-- Header -->
        <div class="invoice-header">
            <div class="logo">
                <img src="{{ asset('assets/img/Logo.png') }}" alt="CEUTrainers Logo" onerror="this.src='https://ui-avatars.com/api/?name=CEUTrainers&background=1ab69d&color=fff&size=128'">
            </div>
            <h1 class="invoice-title">Invoice</h1>
        </div>

        <!-- Metadata Bar -->
        <div class="metadata-bar">
            <div class="metadata-item"></div> <!-- Spacer matching layout screenshot -->
            <div class="d-flex gap-4">
                <div class="metadata-item">
                    Invoice No: <strong>{{ $order->order_number }}</strong>
                </div>
                <div class="metadata-item">
                    Date: <strong>{{ $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s') }}</strong>
                </div>
            </div>
        </div>

        <!-- Recipients Addresses -->
        <div class="recipient-section">
            <!-- Invoice To -->
            <div class="recipient-col">
                <h5>Invoice To:</h5>
                <div class="recipient-details">
                    @if($billingAddress)
                        <strong>{{ $billingAddress->name }}</strong><br>
                        @if($billingAddress->company_name)
                            {{ $billingAddress->company_name }}<br>
                        @endif
                        {{ $billingAddress->address_line_1 }}<br>
                        @if($billingAddress->address_line_2)
                            {{ $billingAddress->address_line_2 }}<br>
                        @endif
                        {{ $billingAddress->city }}, {{ $billingAddress->state }} {{ $billingAddress->postal_code }}<br>
                        {{ $billingAddress->country }}
                    @else
                        <strong>{{ $order->user->name ?? $order->guest_name }}</strong><br>
                        @if($order->user && $order->user->company_name)
                            {{ $order->user->company_name }}<br>
                        @endif
                        @if($order->user && $order->user->phone)
                            Phone: {{ $order->user->phone }}<br>
                        @endif
                        {{ $order->user->email ?? $order->guest_email }}
                    @endif
                </div>
            </div>

            <!-- Pay To -->
            <div class="recipient-col">
                <h5>Pay To:</h5>
                <div class="recipient-details">
                    <strong>304 S. Jones Blvd #5255,</strong><br>
                    Las Vegas, NV, 89107<br>
                    United States<br>
                    Email: <a href="mailto:info@ceutrainers.com" style="color: #1ab69d; text-decoration: none;">info@ceutrainers.com</a>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-container">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">Item</th>
                        <th>Webinar</th>
                        <th>Selling Options</th>
                        <th class="text-right" style="width: 150px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $itemIndex = 1; @endphp
                    @forelse($order->items as $item)
                        <tr>
                            <td class="text-center"><strong>{{ $itemIndex++ }}</strong></td>
                            <td>
                                <strong>{{ $item->title }}</strong>
                                @if($item->course)
                                    <div class="text-muted" style="font-size: 11px; margin-top: 3px;">
                                        Industry: {{ $item->course->industry->name ?? 'General Compliance' }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                {{ $item->description ?: 'Standard Webinar Access' }}
                            </td>
                            <td class="text-right">
                                <strong>${{ number_format($item->total_price, 2) }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No items in this order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Calculations Summary -->
        <div class="summary-block">
            <!-- Payment Info -->
            <div class="payment-info-box">
                <h6>Payment Info:</h6>
                <ul class="payment-info-list">
                    <li>payer Email - <strong>{{ $transaction->payer_email ?? ($order->user->email ?? 'N/A') }}</strong></li>
                    <li>Amount: <strong>${{ number_format($order->grand_total, 2) }}</strong></li>
                    <li>Transaction Id : <strong>{{ $transaction->transaction_id ?? 'N/A' }}</strong></li>
                </ul>
            </div>

            <!-- Summary Calculations -->
            <div class="summary-calculations">
                <div class="calc-row">
                    <span>Subtotal</span>
                    <strong>${{ number_format($order->subtotal, 2) }}</strong>
                </div>
                <div class="calc-row">
                    @php
                        $discountPercent = 0;
                        if ($order->coupon) {
                            $discountPercent = $order->coupon->discount_type === 'percentage' ? (int)$order->coupon->discount_value : 0;
                        }
                    @endphp
                    <span>Discount ({{ $discountPercent }}%)</span>
                    <strong>${{ number_format($order->discount_total, 2) }}</strong>
                </div>
                <div class="calc-row total">
                    <span>Grand Total</span>
                    <span>${{ number_format($order->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="terms-card">
            <h6>Terms & Conditions:</h6>
            <ul class="terms-list">
                <li>Payment(<strong>${{ number_format($order->grand_total, 2) }}</strong>) Processed by <strong>{{ ucfirst($order->payment_gateway ?? 'paypal') }}</strong>, Transaction ID: <strong>{{ $transaction->transaction_id ?? 'N/A' }}</strong>. This is an electronically generated invoice/receipt and does not require any signature or official stamp.</li>
                <li>Billing & Payments: ceutrainers manages the payments done on our website, which are secured through {{ ucfirst($order->payment_gateway ?? 'PayPal/Stripe') }} payment processor. All your bank/credit/debit card/PayPal, and/or any other billing statements will disclose "ceuTrainers Webinar" for your payments done to ceu-trainers.com. For any inquiries regarding yearly subscription, billing info, corrections to your invoice, etc., please contact us at <a href="mailto:support@ceutrainers.com" style="color: #1ab69d; text-decoration: none;">support@ceutrainers.com</a>. Our service hours are: Mon - Fri, 10 am - 5 pm EST. All the delivery are done on email. In case your firewall blocked our email. Please contact us / Write to us/ Go to live Chat. We will Respond to you Soon.</li>
                <li>For terms and use :- <a href="https://ceu-trainers.com/privacy-policy" target="_blank" style="color: #1ab69d; text-decoration: none;">ceu-trainers.com/privacy-policy</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
