<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'email',
            'password'
        ];
    }

    public static function create($data)
    {
        $user = new self();
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);

        return $user->insert();
    }

    public static function attempt($credentials)
    {
        // gets the user by email
        $user = self::findOne(['email' => $credentials['email']]);

        // verifies the user and password
        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return null;
        }

        // login the user
        login($user);
        return true;
    }
}
