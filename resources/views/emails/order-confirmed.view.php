<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | ABG Prime Builders Supplies Inc.</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Outfit', sans-serif; margin: 0; padding: 0; background-color: #FFFFFF;">
    <div style="max-width: 550px; margin: 20px auto; background-color: #F8F9FA; border: 1px solid #DDD; border-radius: 4px; overflow: hidden;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid #DDD; background-color: #F8F9FA;">
            <div style="display: flex; align-items: center;">
                <img src="public/assets/img/abg-logo.png" alt="ABG Prime Builders Supplies Inc." style="height: 40px; margin-right: 10px;">
                <div style="display: flex; flex-direction: column; line-height: 1.1;">
                    <span style="font-size: 20px; font-weight: bold; color: #815331;">ABG Prime</span>
                    <span style="font-size: 15px; color: #8C7D73;">Builders Supplies Inc.</span>
                </div>
            </div>
            <div style="text-align: right;">
                <h1 style="margin: 0; font-size: 20px; font-weight: bold; color: #000000;">Order Confirmed</h1>
                <span style="font-size: 15px; color: #000000;">Thank you for your order!</span>
            </div>
        </div>
        <!-- Body -->
        <div style="background-color: #ECE5DF; padding: 24px;">
            <h2 style="font-size: 16px; font-weight: bold; margin-top: 0;">Order Confirmed!</h2>
            <p style="font-size: 13px;">Hi <strong><?= htmlspecialchars($user->name) ?></strong>,</p>
            <p style="font-size: 13px; margin-bottom: 20px;">Your order #<?= htmlspecialchars($order->id) ?> has been successfully confirmed. Thank you for shopping with us!</p>
            <h2 style="font-size: 14px; font-weight:bold;">Order Summary:</h2>
        </div>
        <!-- Table -->
        <div style="background-color: #F8F9FA; padding: 0 24px; margin-top: 20px; margin-bottom: 20px;">
            <div style="border-radius: 12px; overflow: hidden; border: 1px solid #DDD;">
                <table style="width:100%; border-collapse: collapse; font-size: 13px; table-layout: fixed;">
                    <colgroup>
                        <col style="width: 60%">
                        <col style="width: 20%">
                        <col style="width: 20%">
                    </colgroup>
                    <thead>
                        <tr style="background-color: #ECE5DF;">
                            <th style="padding: 10px; text-align: left; font-weight: normal; color: #8C7D73;">Item</th>
                            <th style="padding: 10px; text-align: right; font-weight: normal; color: #8C7D73;">Qty</th>
                            <th style="padding: 10px; text-align: right; font-weight: normal; color: #8C7D73;">Price</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #FFFFFF;">
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #DDD; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($item->item->item_name) ?>">
                                    <?= htmlspecialchars($item->item->item_name) ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #DDD; text-align: right;"><?= htmlspecialchars($item->quantity) ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #DDD; text-align: right;">&#8369;<?= number_format($item->unit_price * $item->quantity, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #815331; color: #FFFFFF;">
                            <td style="padding: 10px; font-weight: bold;">Total</td>
                            <td style="padding: 10px;"></td>
                            <td style="padding: 10px; text-align: right; font-weight: bold;">&#8369;<?= number_format($order->total_amount, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Additional details -->
        <div style="background-color: #ECE5DF; padding: 24px;">
            <ul style="list-style-type: disc; font-size: 13px; padding-left: 20px; margin: 0;">
                <li style="margin-bottom: 15px;">
                    <strong>Order Confirmed</strong><br>
                    <span>We have successfully confirmed your order and will begin processing it shortly.</span>
                </li>
                <li style="margin-bottom: 15px;">
                    <strong>Preparation</strong><br>
                    <span>We will notify you once your order is ready for delivery.</span>
                </li>
                <li>
                    <strong>Delivery</strong><br>
                    <span>Your order will be delivered to your specified location.</span>
                </li>
            </ul>
        </div>
        <!-- Footer -->
        <div style="background-color: #F8F9FA; padding: 16px 24px; text-align: center; border-top: 1px solid #DDD; font-size: 12px; color: #8C7D73;">
            <p>If you have any questions, visit our page.</p>
            <p style="color: #000000;">- The ABG Prime Builders Supplies Inc. Team</p>
        </div>
        <div style="background-color: #815331; color: #FFFFFF; font-size: 12px; padding: 10px; text-align: center;">
            &copy; 2025 <strong style="color: #FFFFFF;">ABG Prime Builders Supplies Inc.</strong> - Powered by ABG. Building Better, Together.
        </div>
</body>

</html>