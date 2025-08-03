<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    /**
     * Get the table name associated with the model.
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * Get the primary key column name.
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Get the fillable fields for mass assignment.
     */
    public static function fillable(): array
    {
        return [
            'username',
            'email',
            'password',
            'email_verified_at',
            'verification_code',
            'verification_code_expires_at'
        ];
    }

    /**
     * Get all orders for this user
     */
    public function orders()
    {
        return $this->hasMany(Orders::class, 'user_id');
    }

    /**
     * Mark the user's email as verified and clear the verification code.
     */
    public function markEmailAsVerified(): bool
    {
        return self::update($this->id, [
            'email_verified_at' => date('Y-m-d H:i:s'),
            'verification_code' => null,
            'verification_code_expires_at' => null
        ]);
    }

    /**
     * Check if the user's email is verified.
     */
    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Find a user by a valid, unused verification code.
     */
    public static function findByVerificationCode(string $code): ?self
    {
        return self::where([
            'verification_code' => $code,
            'email_verified_at' => null
        ]);
    }

    /**
     * Generate a 6-digit email verification code.
     */
    public static function generateVerificationCode(): string
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
