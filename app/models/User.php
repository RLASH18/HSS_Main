<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return [
            'email',
            'password'
        ];
    }

    public static function attempt($credentials)
    {
        // gets the user by email
        $user = self::where(['email' => $credentials['email']]);

        // verifies the user and password
        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return null;
        }

        // login the user
        login($user);
        return true;
    }
}
