<?php
namespace App\Service\Payment\PaymentStrategy;

use App\Models\Order;

class NullPaymentStrategy implements PaymentStrategy
{
    public function pay(Order $order)
    {
        throw new \Exception('Payment is not available');
    }
}
