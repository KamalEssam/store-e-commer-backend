<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'ar_name',
        'en_name'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    protected $hidden = ['pivot'];

    public function product()
    {
        return $this->belongsToMany(product::class, 'product_colors');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class ,'color_sizes','size_id','variant_id');
    }
}
