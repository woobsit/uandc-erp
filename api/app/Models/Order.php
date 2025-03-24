<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    // Accessor for capitalizing first name
    public function getSenderFullnameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    // Format pickup_time
    public function getPickupTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

    // Format delivery_time_slot
    public function getDeliveryTimeSlotAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

    // Format estimated_delivery_time
    public function getEstimatedDeliveryTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d h:i A') : null;
    }

    // Format actual_delivery_time
    public function getActualDeliveryTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d h:i A') : null;
    }

    // Format total_cost to price format
    public function getTotalCostAttribute($value)
    {
        return '₦' . number_format($value, 0, '.', ',');
    }

    // Format discount to price format
    // Accessor for formatting discount
    public function getDiscountAttribute($value)
    {
        return '₦' . number_format($value, 0, '.', ',');
    }

    // Format distance (assuming it's in kilometers)
    public function getDistanceAttribute($value)
    {
        return number_format($value, 2) . ' km';
    }

    // Format created_at timestamp
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d h:i A');
    }
}
