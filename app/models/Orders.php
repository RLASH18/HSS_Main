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
            'payment_method',
            'total_amount',
            'delivery_method',
            'delivery_address'
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

    /**
     * Calculate the total amount of this order
     */
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->orderItems() as $item) {
            $total += $item->quantity * $item->unit_price;
        }
        return $total;
    }

    /**
     * Load the order's items and their related inventory item.
     * Useful when we need full details about the order contents.
     */
    public function loadItems()
    {
        // Load all items in this order
        $this->orderItems = $this->orderItems();

        // For each order item, load the associated inventory item
        foreach ($this->orderItems as $item) {
            // Assign item relation manually
            $item->item = $item->items();
        }

        return $this;
    }

    /**
     * Get all billing records linked to this order.
     */
    public function billings()
    {
        return $this->hasMany(Billings::class, 'order_id');
    }

    /**
     * Get all deliveries associated with this order
     */
    public function delivery()
    {
        return $this->hasMany(Delivery::class, 'order_id');
    }
}
