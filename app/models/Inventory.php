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
            'supplier_name',
            'item_name',
            'description',
            'category',
            'image',
            'unit_price',
            'quantity',
            'restock_threshold',
            'created_at',
            'updated_at'
        ];
    }
}