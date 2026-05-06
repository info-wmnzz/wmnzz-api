<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'service_title',
        'service_category',
        'city_of_operation',
        'service_desc',
        'price',
        'experience',
        'image',
        'service_provider_address',
        'city',
        'pincode',
        'latitude',
        'longitude',
        'status'
    ];

    public function serviceProviderDetail()
    {
        return $this->hasOne(User::class, 'id','service_provider_id');
    }
}
