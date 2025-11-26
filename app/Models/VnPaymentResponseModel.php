<?php

namespace App\Models;

class VnPaymentResponseModel
{
    public bool $success = false;
    public string $message = '';
    public ?string $vnp_TxnRef = null;
    public ?string $vnp_TransactionNo = null;
    public ?string $vnp_ResponseCode = null;
}

