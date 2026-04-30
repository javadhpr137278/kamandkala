<?php

namespace App\Services\Payment;

interface PaymentInterface
{
    public function pay($order);
    public function verify($request);
}
