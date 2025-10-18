<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | ABG Prime Builders Supplies Inc.</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 20px !important;
            }
            .email-body {
                padding: 20px !important;
            }
            h2 {
                font-size: 20px !important;
            }
            h3 {
                font-size: 16px !important;
            }
            .table-responsive {
                font-size: 12px !important;
            }
            .table-responsive th,
            .table-responsive td {
                padding: 8px 5px !important;
            }
            .total-amount {
                font-size: 14px !important;
            }
        }
        @media only screen and (min-width: 601px) and (max-width: 768px) {
            .email-container {
                padding: 30px !important;
            }
            .email-body {
                padding: 30px !important;
            }
        }
    </style>
</head>

<body style="font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.8; color: #333; margin: 0; padding: 40px; background-color: #f5f5f5;" class="email-container">

    <!-- Center container -->
    <div style="max-width: 700px; margin: 0 auto; background-color: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);" class="email-body">

        <!-- Letterhead / Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin: 0; color: #815331;">ABG Prime Builders Supplies Inc.</h2>
            <p style="margin: 0; font-size: 14px; color: #815331;">Order Confirmation</p>
            <hr style="margin-top: 20px; border: 0; border-top: 2px solid #815331;">
        </div>

        <!-- Date aligned to the right -->
        <p style="text-align: right; font-size: 14px;"><?= date('F j, Y \a\t g:i A', time()) ?></p>

        <!-- Greeting -->
        <p>Dear <?= htmlspecialchars($user->name) ?>,</p>

        <!-- Intro paragraph -->
        <p>
            Thank you for your order! We are pleased to confirm that your order #<?= htmlspecialchars(str_pad($order->id, 4, '0', STR_PAD_LEFT)) ?> 
            has been successfully received and is now being processed.
        </p>

        <!-- Order Summary -->
        <div style="margin: 20px 0; padding: 15px; border: 1px solid #815331; border-radius: 6px; background: #FDFDFD;">
            <h3 style="margin-top: 0;">Order Summary</h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;" class="table-responsive">
                    <thead>
                        <tr style="background-color: #f9f9f9;">
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Item</th>
                            <th style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">Qty</th>
                            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars($item->item->item_name) ?></td>
                            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;"><?= htmlspecialchars($item->quantity) ?></td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">₱<?= number_format($item->unit_price * $item->quantity, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f9f9f9; font-weight: bold;">
                            <td style="padding: 15px; border-top: 2px solid #ddd;">Total Amount</td>
                            <td style="padding: 15px; border-top: 2px solid #ddd;"></td>
                            <td style="padding: 15px; text-align: right; border-top: 2px solid #ddd; font-size: 16px; color: #815331;" class="total-amount">₱<?= number_format($order->total_amount, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Status -->
        <div style="margin: 20px 0; padding: 15px; border: 1px solid #815331; border-radius: 6px; background: #FDFDFD;">
            <h3 style="margin-top: 0;">What's Next?</h3>
            <ul style="margin: 5px 0; padding-left: 20px; line-height: 1.6;">
                <li><strong>Order Confirmed:</strong> We have successfully confirmed your order and will begin processing it shortly.</li>
                <li><strong>Preparation:</strong> We will notify you once your order is ready for delivery.</li>
                <li><strong>Delivery:</strong> Your order will be delivered to your specified location.</li>
            </ul>
        </div>

        <!-- Contact Information -->
        <p>
            If you have any questions about your order, please don't hesitate to contact our customer support team.
            We're here to help!
        </p>

        <!-- Closing -->
        <p>Thank you for choosing ABG Prime Builders Supplies Inc.</p>
        <p>Sincerely,<br><em>The ABG Prime Team</em></p>

        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #815331;">
        <p style="font-size: 12px; color: #815331; text-align: center;">
            This email was automatically generated from the ABG Prime Builders Supplies Inc. order system.
        </p>

    </div> <!-- End center container -->

</body>

</html>