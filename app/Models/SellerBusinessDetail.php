<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBusinessDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'store_name',
        'business_category',
        'gst_number',
        'cin',
        'store_email',
        'store_phone',
        'business_address',
        'city',
        'pincode',
        'latitude',
        'longitude',
        'image',
    ];
}
