<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'service_id',
        'service_provider_id',
        'booking_date',
        'booking_time',
        'address',
        'price',
        'status',
    ];
}
