<?php

namespace app\models;

use app\core\Model;

class OrderItems extends Model
{
    public static function tableName(): string
    {
        return 'order_items';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'order_id',
            'item_id',
            'quantity',
            'unit_price'
        ];
    }

    /**
     * Get the inventory item details
     */
    public function items()
    {
        return $this->belongsTo(Inventory::class, 'item_id');
    }
}
