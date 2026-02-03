<?php
namespace App\Http\Resources\Api\Order;

use App\Http\Resources\Api\PaginationCollection;

class OrdersResource extends PaginationCollection
{

    public function collectionData()
    {
        return OrderResource::collection($this->collection);
    }

}
