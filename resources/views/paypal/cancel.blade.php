<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán bị hủy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #fff6f6;
            color: #7f1d1d;
        }

        .card {
            background: #fff;
            padding: 32px 40px;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(127, 29, 29, 0.25);
            text-align: center;
        }

        h1 {
            margin-bottom: 16px;
        }

        a {
            margin-top: 24px;
            display: inline-block;
            color: #b91c1c;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Thanh toán đã bị hủy</h1>
        <p>Bạn đã hủy giao dịch PayPal. Vui lòng thử lại hoặc chọn phương thức khác.</p>
        <a href="{{ route('cart.show') }}">Quay lại giỏ hàng</a>
    </div>
</body>

</html>

