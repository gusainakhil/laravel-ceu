<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice – {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            background: #fff;
            padding: 0;
            font-size: 13px;
        }


        /* Invoice Card */
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ccc;
        }

        /* ── Top Header ── */
        .inv-top {
            padding: 32px 40px 24px;
            border-bottom: 2px solid #111;
        }

        .inv-top table { width: 100%; border-collapse: collapse; }

        .logo-cell { vertical-align: top; }
        .logo-cell img { max-height: 40px; max-width: 160px; }
        .logo-name { font-size: 18px; font-weight: 900; color: #111; letter-spacing: -0.3px; }
        .logo-sub  { font-size: 11px; color: #555; margin-top: 2px; }

        .inv-word-cell { text-align: right; vertical-align: top; }
        .inv-word { font-size: 42px; font-weight: 900; color: #111; text-transform: uppercase; letter-spacing: -1px; line-height: 1; }
        .inv-meta { font-size: 12px; color: #444; margin-top: 6px; line-height: 1.8; text-align: right; }
        .inv-meta strong { color: #111; }

        .status-badge {
            display: inline-block;
            padding: 2px 10px;
            font-size: 11px;
            font-weight: 700;
            border: 1.5px solid #111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Addresses ── */
        .inv-addresses {
            padding: 24px 40px;
            border-bottom: 1px solid #ddd;
        }

        .inv-addresses table { width: 100%; border-collapse: collapse; }
        .addr-col { vertical-align: top; padding-right: 30px; }
        .addr-col:last-child { padding-right: 0; }
        .addr-heading { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 6px; }
        .addr-name    { font-size: 14px; font-weight: 700; color: #111; margin-bottom: 3px; }
        .addr-detail  { font-size: 12px; color: #444; line-height: 1.7; }

        /* ── Items Table ── */
        .inv-items { padding: 24px 40px; border-bottom: 1px solid #ddd; }

        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 10px;
        }

        .items-table { width: 100%; border-collapse: collapse; }

        .items-table th {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #555;
            padding: 8px 12px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            text-align: left;
        }

        .items-table td {
            padding: 11px 12px;
            border: 1px solid #ddd;
            color: #222;
            font-size: 12.5px;
            vertical-align: top;
        }

        .item-name { font-weight: 700; color: #111; }
        .item-sub  { font-size: 11px; color: #888; margin-top: 2px; }

        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        /* ── Payment + Totals ── */
        .inv-bottom { padding: 24px 40px; border-bottom: 1px solid #ddd; }
        .inv-bottom > table { width: 100%; border-collapse: collapse; }

        .pay-col { width: 55%; vertical-align: top; padding-right: 30px; }
        .tot-col { width: 45%; vertical-align: top; }

        .pay-table { width: 100%; border-collapse: collapse; }
        .pay-table td { padding: 7px 0; border-bottom: 1px solid #eee; font-size: 12px; vertical-align: top; }
        .pay-table tr:last-child td { border-bottom: none; }
        .pay-lbl { color: #888; font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px; width: 110px; padding-right: 10px; white-space: nowrap; }
        .pay-val { color: #111; font-weight: 700; word-break: break-all; overflow-wrap: break-word; }

        .tot-table { width: 100%; border-collapse: collapse; }
        .tot-table td { padding: 8px 0; font-size: 13px; color: #333; border-bottom: 1px solid #eee; }
        .tot-table tr:last-child td { border-bottom: none; }
        .tot-label { }
        .tot-value { text-align: right; font-weight: 700; color: #111; }

        .grand-row td {
            border-top: 2px solid #111 !important;
            padding-top: 12px;
            font-size: 16px;
            font-weight: 900;
            color: #111;
        }

        /* ── Attendees / Access sub-sections ── */
        .inv-sub { padding: 0 40px 24px; }

        /* ── Footer ── */
        .inv-footer {
            padding: 14px 40px;
            border-top: 2px solid #111;
            background: #f9f9f9;
        }

        .inv-footer table { width: 100%; border-collapse: collapse; }
        .foot-left  { font-size: 11px; color: #555; vertical-align: middle; }
        .foot-right { font-size: 11px; color: #888; text-align: right; vertical-align: middle; white-space: nowrap; }

        /* ── Print ── */
        @media print {
            @page { margin: 10mm 12mm; size: A4; }

            body { background: #fff; padding: 0; }

            .invoice { border: none; max-width: 100%; box-shadow: none; }

            .inv-top      { padding: 20px 28px 18px; }
            .inv-addresses{ padding: 18px 28px; }
            .inv-items    { padding: 18px 28px; }
            .inv-bottom   { padding: 18px 28px; }
            .inv-sub      { padding: 0 28px 18px; }
            .inv-footer   { padding: 12px 28px; }
        }
    </style>
</head>
<body>

<div class="invoice">

    {{-- Top Header --}}
    <div class="inv-top">
        <table>
            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('assets/img/Logo.png') }}" alt="CEUTrainers"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                    <div class="logo-name" style="display:none;">CEUTrainers</div>
                    <div class="logo-sub">304 S. Jones Blvd #5255, Las Vegas, NV 89107</div>
                </td>
                <td class="inv-word-cell">
                    <div class="inv-word">Invoice</div>
                    <div class="inv-meta">
                        <strong>#{{ $order->order_number }}</strong><br>
                        {{ optional($order->created_at)->format('M d, Y') }} &nbsp;·&nbsp; {{ optional($order->created_at)->format('h:i A') }}<br>
                        <span class="status-badge">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Addresses --}}
    @php
        $notes   = json_decode($order->notes, true);
        $addr    = $notes['address_snapshot'] ?? null;
        $hasAddr = $addr && !empty($addr['address_line_1']);
    @endphp
    <div class="inv-addresses">
        <table>
            <tr>
                <td class="addr-col" style="width:{{ $hasAddr ? '33%' : '50%' }}">
                    <div class="addr-heading">Bill To</div>
                    @if($order->user)
                        <div class="addr-name">{{ $order->user->name }}</div>
                        <div class="addr-detail">
                            {{ $order->user->email }}<br>
                            @if($order->user->phone) {{ $order->user->phone }}<br> @endif
                            @if($order->user->company_name) {{ $order->user->company_name }}<br> @endif
                            @if($order->user->job_title) {{ $order->user->job_title }} @endif
                        </div>
                    @else
                        <div class="addr-name">{{ $order->guest_name ?: 'Guest' }}</div>
                        <div class="addr-detail">{{ $order->guest_email ?: '—' }}</div>
                    @endif
                </td>

                <td class="addr-col" style="width:{{ $hasAddr ? '33%' : '50%' }}">
                    <div class="addr-heading">Pay To</div>
                    <div class="addr-name">CEUTrainers</div>
                    <div class="addr-detail">
                        304 S. Jones Blvd #5255<br>
                        Las Vegas, NV 89107<br>
                        United States<br>
                        info@ceutrainers.com
                    </div>
                </td>

                @if($hasAddr)
                <td class="addr-col" style="width:33%">
                    <div class="addr-heading">Billing Address</div>
                    <div class="addr-detail">
                        @if(!empty($addr['company_name'])) <strong>{{ $addr['company_name'] }}</strong><br> @endif
                        {{ $addr['address_line_1'] }}<br>
                        @if(!empty($addr['address_line_2'])) {{ $addr['address_line_2'] }}<br> @endif
                        @if(!empty($addr['city'])) {{ $addr['city'] }}, @endif
                        @if(!empty($addr['state'])) {{ $addr['state'] }} @endif
                        @if(!empty($addr['postal_code'])) {{ $addr['postal_code'] }} @endif<br>
                        @if(!empty($addr['country'])) {{ $addr['country'] }} @endif
                    </div>
                </td>
                @endif
            </tr>
        </table>
    </div>

    {{-- Items --}}
    <div class="inv-items">
        <div class="section-title">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:36px;">#</th>
                    <th>Item</th>
                    <th class="text-center" style="width:46px;">Qty</th>
                    <th class="text-right" style="width:90px;">Unit Price</th>
                    <th class="text-right" style="width:90px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @forelse($order->items as $item)
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>
                        <div class="item-name">{{ $item->title }}</div>
                        @if($item->description) <div class="item-sub">{{ $item->description }}</div> @endif
                        <div class="item-sub">{{ ucfirst($item->item_type) }}</div>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format((float)$item->unit_price, 2) }}</td>
                    <td class="text-right"><strong>${{ number_format((float)$item->total_price, 2) }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" style="color:#aaa; padding:20px;">No items found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Payment Info + Totals --}}
    @php $txn = $order->transactions->first(); @endphp
    <div class="inv-bottom">
        <table>
            <tr>
                <td class="pay-col">
                    <div class="section-title">Payment Info</div>
                    <table class="pay-table">
                        <tr>
                            <td class="pay-lbl">Gateway</td>
                            <td class="pay-val">{{ ucfirst($order->payment_gateway ?? '—') }}</td>
                        </tr>
                        <tr>
                            <td class="pay-lbl">Payer Email</td>
                            <td class="pay-val">{{ $txn->payer_email ?? ($order->user->email ?? '—') }}</td>
                        </tr>
                        <tr>
                            <td class="pay-lbl">Transaction ID</td>
                            <td class="pay-val" style="font-size:11px;">{{ $txn->transaction_id ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="pay-lbl">Paid On</td>
                            <td class="pay-val">{{ $txn && $txn->paid_at ? $txn->paid_at->format('M d, Y h:i A') : '—' }}</td>
                        </tr>
                        @if($order->coupon)
                        <tr>
                            <td class="pay-lbl">Coupon</td>
                            <td class="pay-val">{{ $order->coupon->code }}</td>
                        </tr>
                        @endif
                    </table>
                </td>

                <td class="tot-col">
                    <div class="section-title">Summary</div>
                    <table class="tot-table">
                        <tr>
                            <td class="tot-label">Subtotal</td>
                            <td class="tot-value">${{ number_format((float)$order->subtotal, 2) }}</td>
                        </tr>
                        @if($order->discount_total > 0)
                        <tr>
                            <td class="tot-label">Discount</td>
                            <td class="tot-value">-${{ number_format((float)$order->discount_total, 2) }}</td>
                        </tr>
                        @endif
                        @if(!empty($order->tax_total) && $order->tax_total > 0)
                        <tr>
                            <td class="tot-label">Tax</td>
                            <td class="tot-value">${{ number_format((float)$order->tax_total, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="grand-row">
                            <td class="tot-label"><strong>Grand Total</strong></td>
                            <td class="tot-value"><strong>{{ $order->currency ?? 'USD' }} {{ number_format((float)$order->grand_total, 2) }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- Attendees --}}
    @if($order->attendees->count())
    <div class="inv-sub">
        <div class="section-title" style="margin-bottom:10px;">Attendees</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:36px;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Job Title</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->attendees as $idx => $attendee)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td><strong>{{ $attendee->name }}</strong></td>
                    <td>{{ $attendee->email }}</td>
                    <td>{{ $attendee->phone ?: '—' }}</td>
                    <td>{{ $attendee->job_title ?: '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Course Accesses --}}
    @if($courseAccesses->count())
    <div class="inv-sub">
        <div class="section-title" style="margin-bottom:10px;">Granted Course Access</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th style="width:90px;">Access Type</th>
                    <th style="width:90px;">Source</th>
                    <th style="width:90px;">Expires</th>
                    <th style="width:70px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courseAccesses as $access)
                <tr>
                    <td><strong>{{ optional($access->course)->title ?: 'Course Access' }}</strong></td>
                    <td>{{ ucfirst($access->access_type) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $access->access_source)) }}</td>
                    <td>{{ $access->expires_at ? $access->expires_at->format('M d, Y') : 'Lifetime' }}</td>
                    <td>{{ ucfirst($access->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Footer --}}
    <div class="inv-footer">
        <table>
            <tr>
                <td class="foot-left">
                    <strong>CEUTrainers</strong> &nbsp;·&nbsp; 304 S. Jones Blvd #5255, Las Vegas, NV 89107
                    &nbsp;·&nbsp; support@ceutrainers.com
                </td>
                <td class="foot-right">Generated {{ now()->format('M d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
