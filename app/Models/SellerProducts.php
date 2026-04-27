<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_id',
        'seller_id',
        'name',
        'slug',
        'desc',
        'image',
        'status',
        'brand_name',
        'selling_price',
        'mrp_price',
        'stock',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function businessDetail()
    {
        return $this->hasOne(SellerBusinessDetail::class, 'seller_id', 'seller_id');
    }
}
