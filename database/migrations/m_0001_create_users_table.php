<?php

use app\core\Application;

class m_0001_create_users_table
{
    public function up()
    {
        $SQL = "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
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