<?php
namespace App\Service\Payment;

use App\Models\Order;
use App\Service\Payment\PaymentStrategy\CreditCardStrategy;
use App\Service\Payment\PaymentStrategy\NullPaymentStrategy;
use App\Service\Payment\PaymentStrategy\PaypalStrategy;
use App\Service\Payment\PaymentStrategy\VodafoneCashStrategy;

class PaymentContext
{
    private static $context;

    private $aliases = [
        'credit_card'   => CreditCardStrategy::class,
        'vodafone_cash' => VodafoneCashStrategy::class,
        'paypal'        => PaypalStrategy::class,
    ];

    private function __construct()
    {}

    public static function create()
    {
        if (! self::$context) {
            self::$context = new PaymentContext();
        }
        return self::$context;
    }

    private function getPayment($key)
    {
        return $this->aliases[$key] ?? NullPaymentStrategy::class;
    }

    public function performPay(Order $order, $key)
    {
        $class = $this->getPayment($key);
        return (new $class())->pay($order);
    }

}
