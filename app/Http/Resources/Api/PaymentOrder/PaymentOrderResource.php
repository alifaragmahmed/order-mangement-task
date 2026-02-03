<?php
namespace App\Http\Resources\Api\PaymentOrder;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'order_id'       => $this->order_id,
            'amount'         => $this->amount,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'date'           => $this->created_at->format('Y-m-d'),
            'time'           => $this->created_at->format('H:i A'),
        ];
    }

}
