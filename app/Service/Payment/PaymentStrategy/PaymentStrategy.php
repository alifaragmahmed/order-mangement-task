<?php
namespace App\Service\Payment\PaymentStrategy;

use App\Models\Order;

interface PaymentStrategy
{
    public function pay(Order $order);
}
