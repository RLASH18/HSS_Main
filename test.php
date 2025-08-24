<?php
require_once 'bootstrap/app.php';

// Start session to get user
session_start();

echo "<h2>Cart Debug Test</h2>";

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo "<p style='color: red;'> User not logged in</p>";
    echo "<p><a href='/login'>Login here</a></p>";
    exit;
}

$userId = $_SESSION['user']['id'];
echo "<p> User logged in - ID: $userId</p>";

// Check cart items directly from database
try {
    $pdo = app\core\Application::$app->db->pdo;
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Cart items found: " . count($cartItems) . "</p>";
    
    if (empty($cartItems)) {
        echo "<p style='color: red;'> No items in cart - this is why checkout fails!</p>";
        echo "<p>Go add some items to your cart first from the shop page.</p>";
    } else {
        echo "<p style='color: green;'> Cart has items:</p>";
        echo "<ul>";
        foreach ($cartItems as $item) {
            echo "<li>Cart ID: {$item['id']}, Item ID: {$item['item_id']}, Quantity: {$item['quantity']}</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'> Database error: " . $e->getMessage() . "</p>";
}
?>