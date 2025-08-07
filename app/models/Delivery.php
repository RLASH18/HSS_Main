<?php

namespace app\models;

use app\core\Model;

class Delivery extends Model
{
    public static function tableName(): string
    {
        return 'delivery';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'order_id',
            'delivery_method',
            'status',
            'scheduled_date',
            'actual_delivery_date',
            'remarks',
            'driver_name'
        ];  
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}