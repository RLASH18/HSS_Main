<?php

use app\core\Application;

class m_0004_create_order_items_table
{
    public function up()
    {
        $SQL = "CREATE TABLE order_items (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    order_id INT,
                    item_id INT,
                    quantity INT NOT NULL,
                    unit_price DECIMAL(10,2),
                    FOREIGN KEY (order_id) REFERENCES orders(id),
                    FOREIGN KEY (item_id) REFERENCES inventory(id)
                ) ENGINE=INNODB;";

        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $SQL = "DROP TABLE order_items";
        $db = Application::$app->db;
        $db->pdo->exec($SQL);
    }
}
