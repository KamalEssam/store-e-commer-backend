<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizes extends Model
{
    protected $table = 'color_sizes';

    protected $fillable = [
        'variant_id',
        'size_id',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     *  relation to get color
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'variant_id');
    }

    /**
     *  relation to get size
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductColors::class, 'variant_id');
    }
}
