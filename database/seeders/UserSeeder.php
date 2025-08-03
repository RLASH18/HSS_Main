<?php

namespace database\seeders;

use app\core\Application;

class UserSeeder
{
    public static function seedAdmin()
    {
        $db = Application::$app->db;

        // Create default admin user
        $name = 'Admin';
        $username = 'admin';
        $email = 'admin@example.com';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $role = 'admin';
        $verified = date('Y-m-d H:i:s');

        // prevent duplicate admin
        $stmt = $db->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            return;
        }

        // creates the admin
        $stmt = $db->pdo->prepare("INSERT INTO users (name, username, email, password, role, email_verified_at)
                                VALUES (:name, :username, :email, :password, :role, :email_verified_at)");
        $stmt->execute([
            ':name' => $name,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            'role' => $role,
            ':email_verified_at' => $verified
        ]);
    }
}
