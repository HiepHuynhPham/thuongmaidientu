@include('client.layout.header')

<div class="container py-5">
    <h2 class="text-success">Thanh toán VNPay thành công!</h2>
    @if(isset($transaction['vnp_TransactionNo']))
        <p>Mã giao dịch: {{ $transaction['vnp_TransactionNo'] }}</p>
    @endif
    @if(isset($transaction['vnp_Amount']))
        <p>Số tiền: {{ $transaction['vnp_Amount'] / 100 }} VND</p>
    @endif
</div>

@include('client.layout.footer')
