<?php

namespace app\models;

use app\core\Model;

class Billings extends Model
{
    public static function tableName(): string
    {
        return 'billings';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'order_id',
            'payment_method',
            'payment_status',
            'amount_paid',
            'issued_at'
        ];
    }

    /**
     * Get the order associated with this billing.
     */
    public function orders()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
