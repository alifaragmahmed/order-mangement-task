<?php
namespace App\Http\Resources\Api\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'product_name' => $this->product_name,
            'quantity'     => $this->quantity,
            'price'        => $this->price,
        ];
    }

}
