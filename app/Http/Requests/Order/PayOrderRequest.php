<?php
namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;

class PayOrderRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_method' => 'required',
            'order_id'       => 'required|exists:orders,id',
        ];
    }
}
