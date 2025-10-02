<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .header {
            background: #4CAF50;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .content {
            padding: 25px;
        }
        .content h2 {
            margin-top: 0;
            color: #4CAF50;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background: #f1f1f1;
            border-radius: 6px;
        }
        .details p {
            margin: 6px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            background: #4CAF50;
            color: #fff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            padding: 15px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>Order Confirmation</h2>
            <p>Hello <strong>{{ $data['order']->customer_name }}</strong>,</p>
            <p>Thank you for shopping with us! Your order (Order ID: {{ $data['order']->id }}) has been placed successfully.</p>

            <div class="details">
                <p><strong>Txn ID:</strong> {{ $data['order']->txn_id }}</p>
                <p><strong>Amount:</strong> ₹{{ number_format($data['order']->total_amount, 2) }}</p>
                 <p><strong>Order Status:</strong> {{ $data['order']->order_status }}</p>
                <p><strong>Payment Mode:</strong> {{ $data['payment']->payment_mode }}</p>
                <p><strong>Payment Status:</strong> {{ $data['payment']->status }}</p>
                <p><strong>Delivery Status:</strong> {{ $data['order']->dispatch_status }}</p>

                <p>Note : If the payment method is COD then the order is subject to full and final payment at the time of collection</p>



            </div>

            <p>You can track your order anytime by clicking the button below:</p>
            <a href="{{ route('order_status', ['txn_id' => $data['order']->txn_id]) }}" class="button">View Order</a>
        </div>
        <div class="footer">
            <p>Thanks for choosing {{ config('app.name') }}.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
