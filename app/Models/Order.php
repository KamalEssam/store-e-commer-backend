<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(ProductSizes::class, 'order_product', 'order_id', 'size_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
