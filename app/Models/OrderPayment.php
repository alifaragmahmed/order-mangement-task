<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_status',
        'payment_method',
    ];

    const PENDING    = 'pending';
    const SUCCESSFUL = 'successful';
    const FAILED     = 'failed';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
