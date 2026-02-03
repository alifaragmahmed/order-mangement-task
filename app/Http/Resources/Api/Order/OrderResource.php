<?php
namespace App\Http\Resources\Api\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'total' => $this->total,
            'date'  => $this->created_at->format('Y-m-d'),
            'time'  => $this->created_at->format('H:i A'),
            'items' => OrderItemResource::collection($this->items),
        ];
    }

}
