<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #f6f8fb;
            color: #1f2933;
        }

        .card {
            background: #fff;
            padding: 32px 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.15);
            text-align: center;
        }

        h1 {
            margin-bottom: 16px;
        }

        a {
            margin-top: 24px;
            display: inline-block;
            color: #2563eb;
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
        <h1>Thanh toán thành công!</h1>
        <p>Cảm ơn bạn đã hoàn tất giao dịch qua PayPal.</p>
        <a href="{{ route('home') }}">Quay lại trang chủ</a>
    </div>
</body>

</html>

