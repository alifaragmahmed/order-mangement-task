<?php
namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;

class FilterOrderRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => 'nullable|string|in:pending,confirmed,canceled',
        ];
    }
}
