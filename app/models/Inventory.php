<?php

namespace app\models;

use app\core\Model;

class Inventory extends Model
{
    public static function tableName(): string
    {
        return 'inventory';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'brand_name',
            'item_name',
            'description',
            'category',
            'item_image_1',
            'item_image_2',
            'item_image_3',
            'unit_price',
            'quantity',
            'restock_threshold',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get all order items for this inventory item
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'item_id');
    }

    /**
     * Get all cart entries that include this inventory item
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'item_id');
    }
}
