<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | ABG Prime Builders Supplies Inc.</title>
</head>

<body style="margin:0; padding:0; background-color:#FFFFFF; font-family:'Outfit', sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF;">
        <tr>
            <td align="center">
                <!-- Main container -->
                <table width="550" cellpadding="0" cellspacing="0" border="0" style="background-color:#F8F9FA; border:1px solid #DDD; border-radius:4px;">
                    <!-- Header -->
                    <tr>
                        <td style="padding:16px 24px; background-color:#F8F9FA; border-bottom:1px solid #DDD;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <!-- Company Name -->
                                    <td>
                                        <span style="font-size:20px; font-weight:bold; color:#815331;">ABG Prime</span><br>
                                        <span style="font-size:15px; color:#8C7D73;">Builders Supplies Inc.</span>
                                    </td>
                                    <!-- Order Header -->
                                    <td align="right">
                                        <span style="font-size:20px; font-weight:bold; color:#000000;">Order Confirmed</span><br>
                                        <span style="font-size:15px; color:#000000;">Thank you for your order!</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:24px; background-color:#ECE5DF;">
                            <p style="color: #000000; font-size:13px; margin:0;">Hi <strong><?= htmlspecialchars($user->name) ?></strong>,</p>
                            <p style="color: #000000; font-size:13px; margin:10px 0 20px 0;">Your order #<?= htmlspecialchars($order->id) ?> has been successfully confirmed. Thank you for shopping with us!</p>
                            <p style="color: #000000; font-size:14px; font-weight:bold; margin:0 0 10px 0;">Order Summary:</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="height:20px; line-height:20px; font-size:0;">&nbsp;</td>
                    </tr>

                    <!-- Table -->
                    <tr>
                        <td style="padding:0 24px 20px 24px; background-color:#F8F9FA;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; font-size:13px;">
                                <thead>
                                    <tr style="background-color:#ECE5DF;">
                                        <th align="left" style="padding:10px; color:#8C7D73; font-weight:normal;">Item</th>
                                        <th align="right" style="padding:10px; color:#8C7D73; font-weight:normal;">Qty</th>
                                        <th align="right" style="padding:10px; color:#8C7D73; font-weight:normal;">Price</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color:#FFFFFF;">
                                    <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td style="color: #000000; padding:10px; border-bottom:1px solid #DDD; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($item->item->item_name) ?>">
                                            <?= htmlspecialchars($item->item->item_name) ?>
                                        </td>
                                        <td style="color: #000000; padding:10px; border-bottom:1px solid #DDD; text-align:right;"><?= htmlspecialchars($item->quantity) ?></td>
                                        <td style="color: #000000; padding:10px; border-bottom:1px solid #DDD; text-align:right;">&#8369;<?= number_format($item->unit_price * $item->quantity, 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color:#815331; color:#FFFFFF;">
                                        <td style="padding:10px; font-weight:bold;">Total</td>
                                        <td style="padding:10px;"></td>
                                        <td style="padding:10px; text-align:right; font-weight:bold;">&#8369;<?= number_format($order->total_amount, 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <!-- Additional Details -->
                    <tr>
                        <td style="padding:24px; background-color:#ECE5DF;">
                            <ul style="margin:0; padding-left:20px; font-size:13px;">
                                <li style="color: #000000; margin-bottom:15px;"><strong>Order Confirmed</strong><br>We have successfully confirmed your order and will begin processing it shortly.</li>
                                <li style="color: #000000; margin-bottom:15px;"><strong>Preparation</strong><br>We will notify you once your order is ready for delivery.</li>
                                <li style="color: #000000; margin-bottom:15px;"><strong>Delivery</strong><br>Your order will be delivered to your specified location.</li>
                            </ul>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:16px 24px; background-color:#F8F9FA; text-align:center; border-top:1px solid #DDD; font-size:12px; color:#8C7D73;">
                            <p>If you have any questions, visit our page.</p>
                            <p style="color:#000000;">- The ABG Prime Builders Supplies Inc. Team</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px; background-color:#815331; color:#FFFFFF; text-align:center; font-size:12px;">
                            &copy; 2025 <strong>ABG Prime Builders Supplies Inc.</strong> - Powered by ABG. Building Better, Together.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>