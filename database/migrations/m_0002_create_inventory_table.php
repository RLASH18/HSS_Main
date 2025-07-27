<?php

use app\core\Application;

class m_0002_create_inventory_table
{
    public function up()
    {
        $SQL = "CREATE TABLE inventory (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    supplier_name VARCHAR(100),
                    item_name VARCHAR(100) NOT NULL,
                    description TEXT,
                    category VARCHAR(100),
                    image VARCHAR(255),
                    unit_price DECIMAL(10, 2) NOT NULL,
                    quantity INT NOT NULL,
                    restock_threshold INT DEFAULT 10,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=INNODB;";

        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $SQL = "DROP TABLE inventory;";
        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }
}
