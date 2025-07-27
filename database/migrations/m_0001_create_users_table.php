<?php

use app\core\Application;

class m_0001_create_users_table
{
    public function up()
    {
        $SQL = "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    username VARCHAR(100),
                    email VARCHAR(100) UNIQUE,
                    password VARCHAR(255),
                    role ENUM('customer', 'admin') DEFAULT 'customer',
                    address TEXT,
                    contact_number VARCHAR(20),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
