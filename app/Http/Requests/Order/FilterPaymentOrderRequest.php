<?php
namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;

class FilterPaymentOrderRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_id' => 'nullable|exists:orders,id',
        ];
    }
}
