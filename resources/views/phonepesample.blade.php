<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhonePe Payment Checkout</title>
    <style>
        .error { color: red; }
        .loading { display: none; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Checkout</h1>
    <div id="error-messages" class="error"></div>
    <form id="payment-form">
        @csrf
        <div class="form-group">
            <label for="amount">Amount (INR):</label>
            <input type="number" name="amount" value="100" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="order_id">Order ID:</label>
            <input type="text" name="order_id" value="ORD{{ rand(1000, 9999) }}" required>
        </div>
        <div class="form-group">
            <label for="uid">User ID:</label>
            <input type="text" name="uid" value="USER{{ rand(1000, 9999) }}" required>
        </div>
        <div class="form-group">
            <label for="coupon_name">Coupon Name (optional):</label>
            <input type="text" name="coupon_name" value="">
        </div>
        <button type="submit" id="pay-button">Pay Now</button>
        <span id="loading" class="loading">Processing...</span>
    </form>
    <div id="phonepe-checkout-container"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#payment-form').on('submit', function (e) {
                e.preventDefault();
                $('#pay-button').prop('disabled', true);
                $('#loading').show();
                $('#error-messages').empty();

                $.ajax({
                    url: '{{ route('phonepe.initiate') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        $('#pay-button').prop('disabled', false);
                        $('#loading').hide();
                        if (response.success) {
                            if (response.data.checkout_method === 'redirect') {
                                window.location.href = response.data.redirectUrl;
                            } else {
                                initiatePhonePeIframeCheckout(response.data);
                            }
                        } else {
                            $('#error-messages').text('Error: ' + response.error + (response.details ? ' - ' + JSON.stringify(response.details) : ''));
                        }
                    },
                    error: function (xhr) {
                        $('#pay-button').prop('disabled', false);
                        $('#loading').hide();
                        $('#error-messages').text('Error: ' + (xhr.responseJSON?.error || 'An unexpected error occurred'));
                    }
                });
            });

            function initiatePhonePeIframeCheckout(data) {
                console.log('Initiating PhonePe Iframe Checkout with data:', data);
                var redirectUrl = '{{ route('phonepe.process') }}' +
                    '?uid=' + encodeURIComponent('{{ session('chartmonks_student_login', '') }}') +
                    '&sub_id=' + encodeURIComponent('{{ session('sub_id', '') }}') +
                    '&amount=' + encodeURIComponent('{{ session('amount', '') }}') +
                    '&coupon_name=' + encodeURIComponent('{{ session('coupon_name', '') }}') +
                    '&orderid=' + encodeURIComponent(data.orderId) +
                    '&moid=' + encodeURIComponent(data.merchantOrderId);

                var script = document.createElement('script');
                script.src = 'https://mercury.phonepe.com/web/bundle/checkout.js';
                script.onload = function () {
                    if (window.PhonePeCheckout && window.PhonePeCheckout.transact) {
                        window.PhonePeCheckout.transact({
                            tokenUrl: data.redirectUrl,
                            callback: function (response) {
                                switch (response) {
                                    case 'USER_CANCEL':
                                        $('#error-messages').text('Payment was cancelled by the user.');
                                        window.location.href = '{{ route('phonepe.checkout') }}';
                                        break;
                                    case 'CONCLUDED':
                                        window.location.href = redirectUrl;
                                        break;
                                    default:
                                        $('#error-messages').text('Payment error: ' + response);
                                        window.location.href = '{{ route('phonepe.error') }}';
                                }
                            },
                            type: 'IFRAME'
                        });
                    } else {
                        $('#error-messages').text('PhonePeCheckout is not available.');
                        window.location.href = '{{ route('phonepe.checkout') }}';
                    }
                };
                script.onerror = function () {
                    $('#error-messages').text('Failed to load PhonePe Checkout SDK.');
                    window.location.href = '{{ route('phonepe.checkout') }}';
                };
                document.head.appendChild(script);
            }
        });
    </script>
</body>
</html>
