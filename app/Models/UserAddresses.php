<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddresses extends Model
{
    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'lat',
        'lng',
        'type',
        'street_name',
        'building_no',
        'apartment_no',
        'floor_no',
        'additional',
        'is_default',
    ];

    protected $casts = [
        'id' => 'integer',
        'lat' => 'double',
        'lng' => 'double',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
