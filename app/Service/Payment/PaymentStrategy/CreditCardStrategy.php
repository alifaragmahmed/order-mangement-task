<?php
namespace App\Service\Payment\PaymentStrategy;

use App\Models\Order;
use App\Models\OrderPayment;

class CreditCardStrategy implements PaymentStrategy
{
    public function pay(Order $order)
    {
        return OrderPayment::create([
            'order_id'       => $order->id,
            'amount'         => $order->total,
            'payment_method' => 'credit_card',
            'payment_status' => OrderPayment::SUCCESSFUL,
        ]);
    }
}
