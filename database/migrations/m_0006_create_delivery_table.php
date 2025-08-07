<?php

use app\core\Application;

class m_0006_create_delivery_table
{
    public function up()
    {
        $SQL = "CREATE TABLE delivery (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    order_id INT,
                    delivery_method ENUM('pickup', 'delivery'),
                    status ENUM('scheduled', 'rescheduled', 'in_transit', 'delivered', 'failed') DEFAULT 'scheduled',
                    scheduled_date DATE,
                    actual_delivery_date DATE,
                    remarks TEXT,
                    driver_name VARCHAR(100),
                    delivery_code VARCHAR(10),
                    qr_token VARCHAR(64),
                    FOREIGN KEY (order_id) REFERENCES orders(id)
                ) ENGINE=INNODB;";

        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $SQL = "DROP TABLE delivery;";
        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }
}
