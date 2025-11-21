<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 0 16px;
            color: #222;
        }

        h1 {
            text-align: center;
        }

        #paypal-button-container {
            margin-top: 24px;
        }

        .amount-summary {
            margin-top: 12px;
            padding: 12px;
            background: #f5f5f5;
            border-radius: 6px;
        }

        .amount-summary strong {
            font-size: 1.1rem;
        }

        .actions {
            margin-top: 24px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Thanh toán PayPal</h1>

    <div class="amount-summary" id="paypal-button-container" data-amount="{{ number_format($paypalAmount, 2, '.', '') }}"
        data-currency="{{ $paypalCurrency }}">
        <p>Số tiền thanh toán:</p>
        <strong>{{ number_format($paypalAmount, 2) }} {{ strtoupper($paypalCurrency) }}</strong>
    </div>

    <div class="actions">
        <div id="paypal-button-wrapper"></div>
        <p style="margin-top:16px;">
            <a href="{{ route('home') }}">Quay lại trang chủ</a>
        </p>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $paypalCurrency }}&intent=CAPTURE"
        data-sdk-integration-source="button-factory"></script>
    <script>
        const paypalContainer = document.getElementById('paypal-button-container');
        const paypalWrapper = document.getElementById('paypal-button-wrapper');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const orderValue = paypalContainer.dataset.amount || '0.00';
        const orderCurrency = paypalContainer.dataset.currency || 'USD';

        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'silver',
                tagline: false,
            },
            async createOrder(data, actions) {
                try {
                    const response = await fetch("{{ route('api.paypal.orders.create') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json",
                        },
                        body: JSON.stringify({
                            value: orderValue,
                            currency_code: orderCurrency,
                        }),
                    });
                    const order = await response.json();
                    if (!response.ok || !order.id) throw new Error(order.message || 'Không thể tạo đơn thanh toán PayPal.');
                    return order.id;
                } catch (error) {
                    console.warn('PayPal createOrder warning (fallback to client create):', error);
                    return actions.order.create({
                        purchase_units: [{ amount: { value: orderValue, currency_code: orderCurrency } }]
                    });
                }
            },
            async onApprove(data, actions) {
                try {
                    const response = await fetch(`{{ route('api.paypal.orders.capture') }}?orderId=${data.orderID}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json",
                        },
                    });
                    const details = await response.json();
                    if (response.ok && details.status === 'COMPLETED') {
                        window.location.href = "{{ route('paypal.success') }}";
                        return;
                    }
                    const clientDetails = await actions.order.capture();
                    window.location.href = "{{ route('paypal.success') }}";
                } catch (error) {
                    console.warn('PayPal onApprove warning (fallback to client capture):', error);
                    alert('Có lỗi xảy ra với PayPal. Vui lòng thử lại.');
                }
            },
            onCancel() {
                window.location.href = "{{ route('paypal.cancel') }}";
            },
            onError(err) {
                console.error(err);
                alert('Có lỗi xảy ra với PayPal. Vui lòng thử lại sau.');
            }
        }).render('#paypal-button-wrapper');
    </script>
</body>

</html>


