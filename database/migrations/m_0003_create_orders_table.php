<?php

use app\core\Application;

class m_0003_create_orders_table
{
    public function up()
    {
        $SQL = "CREATE TABLE orders (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT,
                    status ENUM(
                        'pending', 
                        'confirmed', 
                        'assembled', 
                        'shipped', 
                        'delivered',
                        'paid', 
                        'cancelled'
                    ) DEFAULT 'pending',
                    total_amount DECIMAL(10,2),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id)
                ) ENGINE=INNODB;";

        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $SQL = "DROP TABLE orders;";
        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }
}
