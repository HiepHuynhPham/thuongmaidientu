<?php

namespace App\Models;

class VnPaymentRequestModel
{
    public int $amount;
    public string $description;
    public string $fullName;
    public string $orderId;
    public \DateTimeInterface $createdDate;
}

