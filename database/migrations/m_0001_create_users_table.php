<?php

use app\core\Application;

class m_0001_create_users_table
{
    public function up()
    {
        $SQL = "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100),
                    username VARCHAR(100),
                    email VARCHAR(100),
                    password VARCHAR(255),
                    role ENUM('customer', 'admin') DEFAULT 'customer',
                    profile_picture VARCHAR(255),
                    address TEXT,
                    contact_number VARCHAR(20),
                    birthdate DATE,
                    gender ENUM('male', 'female'),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=INNODB;";

        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $SQL = "DROP TABLE users;";
        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }
}
