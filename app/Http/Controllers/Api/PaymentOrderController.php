<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\FilterPaymentOrderRequest;
use App\Http\Requests\Order\PayOrderRequest;
use App\Http\Resources\Api\PaymentOrder\PaymentOrdersResource;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Service\Payment\PaymentContext;
use Illuminate\Support\Facades\DB;

class PaymentOrderController extends Controller
{

    protected $paginate = 20;

    /**
     * List user orders
     */
    public function index(FilterPaymentOrderRequest $request)
    {
        $orders = OrderPayment::where(function ($query) use ($request) {
            if ($request->order_id) {
                $query->where('order_id', $request->order_id);
            }
        })
            ->latest()
            ->paginate($this->paginate);

        return response()->json(new PaymentOrdersResource($orders));
    }

    /**
     * pay order api
     */
    public function pay(PayOrderRequest $request)
    {
        try {
            $data = $request->validated();

            return DB::transaction(function () use ($data) {
                $id    = $data['order_id'];
                $order = Order::where('id', $id)
                    ->where('user_id', auth('api')->user()->id)
                    ->firstOrFail();

                // check if order in confirmed status
                if ($order->status !== Order::CONFIRMED) {
                    return response()->json([
                        'message' => 'Order is not confirmed',
                    ], 400);
                }

                // perform order payment
                $res = PaymentContext::create()->performPay($order, $data['payment_method']);

                return response()->json([
                    'message' => 'Order paid successfully',
                    'payment' => $res,
                ], 200);
            });
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}
