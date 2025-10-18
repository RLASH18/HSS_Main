<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Message</title>
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
            .info-box {
                padding: 12px !important;
            }
            blockquote {
                padding: 12px !important;
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
            <p style="margin: 0; font-size: 14px; color: #815331;">Customer Support Team</p>
            <hr style="margin-top: 20px; border: 0; border-top: 2px solid #815331;">
        </div>

        <!-- Date aligned to the right -->
        <p style="text-align: right; font-size: 14px;"><?= date('F j, Y \a\t g:i A', time()) ?></p>

        <!-- Greeting -->
        <p>Dear Support Team,</p>

        <!-- Intro paragraph -->
        <p>
            I am writing to inform you that a new inquiry has been submitted through the company’s
            website contact form. Below are the details of the customer’s request for your reference:
        </p>

        <!-- Customer Information -->
        <div style="margin: 20px 0; padding: 15px; border: 1px solid #815331; border-radius: 6px; background: #FDFDFD;" class="info-box">
            <h3 style="margin-top: 0;">Customer Information</h3>
            <p style="margin: 5px 0;">
                <strong>Name:</strong> <?= htmlspecialchars($name) ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($email) ?><br>
                <strong>Phone:</strong> <?= htmlspecialchars($phone) ?><br>
                <strong>Customer Details:</strong>
                <?php if (isset($user) && $user): ?>
                    Customer ID: #<?= htmlspecialchars(str_pad($user->id, 4, '0', STR_PAD_LEFT)) ?> | Username: <?= htmlspecialchars($user->username) ?>
                <?php else: ?>
                    Customer ID: #0000 | Username: Guest User
                <?php endif; ?>
            </p>
        </div>

        <!-- Message Summary -->
        <div style="margin: 20px 0; padding: 15px; border: 1px solid #815331; border-radius: 6px; background: #FDFDFD;" class="info-box">
            <h3 style="margin-top: 0;">Message Summary</h3>
            <p style="margin: 5px 0;">
                <strong>Subject:</strong> <?= htmlspecialchars($subject) ?><br>
                <strong>Priority:</strong> <?= htmlspecialchars($priority) ?><br>
                <strong>Preferred Response:</strong> <?= htmlspecialchars($response_method) ?>
            </p>
        </div>

        <!-- Customer Message -->
        <h3>Customer's Message</h3>
        <blockquote style="margin: 15px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #815331;">
            <?= nl2br(htmlspecialchars($message)) ?>
        </blockquote>

        <!-- Action -->
        <p>
            Kindly respond to the customer at <strong><?= htmlspecialchars($email) ?></strong>
            <?php if ($response_method === 'Phone' || $response_method === 'Both'): ?>
                or by phone at <strong><?= htmlspecialchars($phone) ?></strong>
                <?php endif; ?>.
        </p>

        <!-- Response Guidelines -->
        <p>
            <strong>Response Time Guidelines:</strong><br>
            • Critical/High Priority: within 2–4 hours (business hours)<br>
            • Medium Priority: within 24 hours<br>
            • Low Priority: within 48 hours<br>
            • Business Hours: Monday–Saturday, 8:00 AM – 6:00 PM (GMT+8)
        </p>

        <!-- Closing -->
        <p>Thank you for attending to this matter promptly.</p>
        <p>Sincerely,<br><em>Website Contact Form System</em></p>

        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #815331;">
        <p style="font-size: 12px; color: #815331; text-align: center;">
            This email was automatically generated from the ABG Prime Builders Supplies Inc. website contact form.
        </p>

    </div> <!-- End center container -->

</body>

</html>