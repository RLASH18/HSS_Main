<?php

namespace app\models;

use app\core\Model;

class Cart extends Model
{
    public static function tableName(): string
    {
        return 'cart';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'user_id',
            'item_id',
            'quantity',
        ];
    }

    /**
     * Get the user that owns this cart entry
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the inventory item associated with this cart entry
     */
    public function item()
    {
        return $this->belongsTo(Inventory::class, 'item_id');
    }
}
