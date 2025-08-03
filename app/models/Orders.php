<?php

namespace app\models;

use app\core\Model;

class Orders extends Model
{
    public static function tableName(): string
    {
        return 'orders';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'user_id',
            'status',
            'total_amount'
        ];
    }

    /**
     * Get the user who placed this order
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all items in this order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
