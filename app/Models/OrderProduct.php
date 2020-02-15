<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',
        'quantity',
        'variant_id',
        'product_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'order_id' => 'order_id',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function variant()
    {
        return $this->belongsTo(ProductSizes::class, 'variant_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
