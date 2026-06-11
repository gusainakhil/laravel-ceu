<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmation</title>
<style>
    body { margin: 0; padding: 0; background: #f4fafa; font-family: Arial, sans-serif; color: #242424; }
    .wrap { max-width: 620px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
    .header { background: #1ab69d; padding: 32px 40px; text-align: center; }
    .header h1 { margin: 0; color: #ffffff; font-size: 26px; font-weight: 900; letter-spacing: 0.5px; }
    .header p { margin: 6px 0 0; color: rgba(255,255,255,0.85); font-size: 14px; }
    .body { padding: 36px 40px; }
    .greeting { font-size: 17px; margin-bottom: 20px; }
    .order-box { border: 1px solid #e7e7e7; border-radius: 6px; padding: 24px; margin-bottom: 28px; }
    .order-box h2 { margin: 0 0 18px; font-size: 16px; color: #171717; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .order-meta { font-size: 14px; color: #555; margin-bottom: 6px; }
    .order-meta span { color: #171717; font-weight: 700; }
    .divider { border: 0; border-top: 1px solid #e7e7e7; margin: 18px 0; }
    .item-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 15px; }
    .item-row:last-child { border-bottom: 0; }
    .item-name { color: #1ab69d; font-weight: 700; flex: 1; padding-right: 16px; }
    .item-meta { font-size: 12px; color: #888; margin-top: 2px; }
    .item-price { font-weight: 800; white-space: nowrap; }
    .totals { margin-top: 16px; }
    .total-row { display: flex; justify-content: space-between; font-size: 14px; padding: 5px 0; color: #555; }
    .total-row.grand { font-size: 17px; font-weight: 900; color: #1ab69d; border-top: 2px solid #e7e7e7; padding-top: 12px; margin-top: 6px; }
    .cta { text-align: center; margin: 28px 0; }
    .cta a { background: #1ab69d; color: #ffffff !important; text-decoration: none; padding: 14px 36px; border-radius: 6px; font-size: 16px; font-weight: 800; display: inline-block; }
    .footer { background: #f4fafa; padding: 24px 40px; text-align: center; font-size: 13px; color: #999; border-top: 1px solid #e7e7e7; }
    .footer a { color: #1ab69d; text-decoration: none; }
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>CEUTrainers</h1>
        <p>Order Confirmation</p>
    </div>

    <div class="body">
        <p class="greeting">Hi <strong>{{ $order->user->name }}</strong>,</p>
        <p style="font-size:15px; margin-top:0;">Thank you for your purchase! Your order has been confirmed and your access is being set up.</p>

        <div class="order-box">
            <h2>Order Details</h2>
            <div class="order-meta">Order Number: <span>#{{ $order->order_number }}</span></div>
            <div class="order-meta">Date: <span>{{ $order->created_at->format('F j, Y') }}</span></div>
            <div class="order-meta">Payment: <span>{{ ucfirst($order->payment_gateway) }}</span></div>
            <hr class="divider">

            @foreach($order->items as $item)
            <div class="item-row">
                <div>
                    <div class="item-name">{{ $item->title }}</div>
                    <div class="item-meta">{{ $item->description }}</div>
                </div>
                <div class="item-price">${{ number_format($item->total_price, 2) }}</div>
            </div>
            @endforeach

            <div class="totals">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_total > 0)
                <div class="total-row">
                    <span>Discount</span>
                    <span>-${{ number_format($order->discount_total, 2) }}</span>
                </div>
                @endif
                <div class="total-row grand">
                    <span>Total Paid</span>
                    <span>${{ number_format($order->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="cta">
            <a href="{{ url('/dashboard') }}">View My Dashboard</a>
        </div>

        <p style="font-size:14px; color:#777; margin-top:24px;">If you have any questions about your order, please reply to this email and we'll be happy to help.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} CEUTrainers. All rights reserved.<br>
        <a href="{{ url('/') }}">Visit our website</a>
    </div>
</div>
</body>
</html>
