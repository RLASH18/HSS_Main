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
            'item_code',
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
     * Get category prefix mapping
     * Maps category names to their 2-letter codes
     */
    public static function getCategoryPrefix(string $category): string
    {
        $prefixes = [
            'Hand Tools' => 'HT',
            'Power Tools' => 'PT',
            'Construction Materials' => 'CM',
            'Locks and Security' => 'LS',
            'Plumbing' => 'PL',
            'Electrical' => 'EL',
            'Paint and Finishes' => 'PF',
            'Chemicals' => 'CH'
        ];

        return $prefixes[$category] ?? 'XX';
    }

    /**
     * Generate next item code for a given category
     * Format: PREFIX + 3-digit number (e.g., CH001, HT002)
     */
    public static function generateItemCode(string $category): string
    {
        $prefix = self::getCategoryPrefix($category);
        
        // Get the highest item code for this category using ORM
        $lastItem = self::whereManyOrdered(
            ['category' => $category],
            'item_code',
            'DESC',
            1,
            true
        );

        if (!$lastItem || empty($lastItem->item_code)) {
            // First item in this category
            return $prefix . '001';
        }

        // Extract number from last item code (e.g., CH005 -> 5)
        $lastCode = $lastItem->item_code;
        $lastNumber = (int) substr($lastCode, 2); // Get digits after prefix
        
        // Increment and format with leading zeros
        $nextNumber = $lastNumber + 1;
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
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
