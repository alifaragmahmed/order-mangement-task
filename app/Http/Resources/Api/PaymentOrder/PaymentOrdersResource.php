<?php
namespace App\Http\Resources\Api\PaymentOrder;

use App\Http\Resources\Api\PaginationCollection;

class PaymentOrdersResource extends PaginationCollection
{

    public function collectionData()
    {
        return PaymentOrderResource::collection($this->collection);
    }

}
