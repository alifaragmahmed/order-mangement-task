<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\FilterOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Api\Order\OrdersResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    protected $paginate = 20;

    /**
     * List user orders
     */
    public function index(FilterOrderRequest $request)
    {
        $orders = Order::with(['items', 'payment'])
            ->where('user_id', auth('api')->user()->id)
            ->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->where('status', $request->status);
                }
            })
            ->latest()
            ->paginate($this->paginate);

        return response()->json(new OrdersResource($orders));
    }

    /**
     * Store new order (items + payment)
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {

            // Create order
            $order = Order::create([
                'user_id' => auth('api')->user()->id,
                'status'  => Order::PENDING ?? 'pending',
                'total'   => 0,
            ]);

            // Create items
            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['quantity'];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
            }

            // Update total
            $order->update(['total' => $total]);

            return response()->json([
                'message' => 'Order created successfully',
                'order'   => $order->load(['items']),
            ], 200);
        });
    }

    /**
     * Store new order (items + payment)
     */
    public function update(StoreOrderRequest $request, $id)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data, $id) {
            $order = Order::where('id', $id)
                ->where('user_id', auth('api')->user()->id)
                ->firstOrFail();

            // delete old items
            $order->items()->delete();

            // Add New items
            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['quantity'];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
            }

            // Update total
            $order->update(['total' => $total]);

            return response()->json([
                'message' => 'Order updated successfully',
                'order'   => $order->load(['items']),
            ], 200);
        });
    }

    /**
     * Delete order
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth('api')->user()->id)
            ->firstOrFail();

        if ($order->payment) {
            return response()->json([
                'message' => 'Cannot delete order with payment',
            ]);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
        ]);
    }
}
