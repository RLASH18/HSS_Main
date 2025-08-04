<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>

<body>
    <div>
        <h1>Order Confirmed!</h1>
        <p>Hi <strong><?= htmlspecialchars($user->name) ?></strong>,</p>
        <p>Your order <strong>#<?= htmlspecialchars($order->id) ?></strong> has been successfully confirmed. Thank you for shopping with us!</p>
        <h2>Order Summary:</h2>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->item->item_name) ?></td>
                        <td><?= htmlspecialchars($item->quantity) ?></td>
                        <td>₱<?= number_format($item->unit_price * $item->quantity, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total</td>
                    <td></td>
                    <td>₱<?= number_format($order->total_amount, 2) ?></td>
                </tr>
            </tfoot>
        </table>
        <p>We will notify you once your order is ready for delivery.</p>
        <p>If you have any questions, feel free to reply to this email.</p>
        <p>- The ABG Prime Builders Inc. Team</p>
    </div>
</body>

</html>