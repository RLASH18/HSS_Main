<?php

use app\core\Application;

class m_0005_create_billings_table
{
    public function up()
    {
        $SQL = "CREATE TABLE billings (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    order_id INT,
                    payment_method ENUM('cash', 'gcash', 'bank_transfer'),
                    payment_status ENUM('unpaid', 'paid') DEFAULT 'unpaid',
                    amount_paid DECIMAL(10,2),
                    issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (order_id) REFERENCES orders(id)
                ) ENGINE=INNODB;";

        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $SQL = "DROP TABLE billings;";
        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }
}
