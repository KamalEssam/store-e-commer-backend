<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';

    protected $fillable = [
        'ar_name',
        'en_name'
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
