<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'order_type_id' => 'integer',
        'payment_method_id' => 'integer',
        'status' => 'boolean',
    ];

    public function orderVsProduct()
    {
        return $this->belongsTo(OrderVsProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}
