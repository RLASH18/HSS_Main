<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Email Verification | ABG Prime Builders Supplies Inc.</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.8; color: #333; margin: 0; padding: 40px; background-color: #f5f5f5;">

    <!-- Center container -->
    <div style="max-width: 700px; margin: 0 auto; background-color: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

        <!-- Letterhead / Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin: 0; color: #815331;">ABG Prime Builders Supplies Inc.</h2>
            <p style="margin: 0; font-size: 14px; color: #815331;">Email Verification</p>
            <hr style="margin-top: 20px; border: 0; border-top: 2px solid #815331;">
        </div>

        <!-- Date aligned to the right -->
        <p style="text-align: right; font-size: 14px;"><?= date('F j, Y \a\t g:i A', time()) ?></p>

        <!-- Greeting -->
        <p>Welcome!</p>

        <!-- Intro paragraph -->
        <p>
            Thank you for registering with ABG Prime Builders Supplies Inc. To complete your account setup and 
            ensure the security of your account, please verify your email address using the verification code below.
        </p>

        <!-- Verification Code Section -->
        <div style="margin: 30px 0; padding: 25px; border: 1px solid #815331; border-radius: 6px; background: #FDFDFD; text-align: center;">
            <h3 style="margin-top: 0;">Your Verification Code</h3>
            <div style="display: inline-block; background-color: white; padding: 20px 30px; border-radius: 8px; border: 2px solid #815331; margin: 15px 0;">
                <span style="font-size: 28px; font-weight: bold; letter-spacing: 8px; color: #815331; font-family: 'Courier New', monospace;">
                    <?= htmlspecialchars($code) ?>
                </span>
            </div>
            <p style="margin: 15px 0 5px 0; font-size: 14px; color: #666;">
                <strong>Important:</strong> This verification code will expire in <strong>5 minutes</strong>.
            </p>
        </div>

        <!-- Instructions -->
        <div style="margin: 20px 0; padding: 15px; border: 1px solid #815331; border-radius: 6px; background: #FDFDFD;">
            <h3 style="margin-top: 0;">How to Use This Code</h3>
            <ol style="margin: 5px 0; padding-left: 20px; line-height: 1.6;">
                <li>Return to the verification page on our website</li>
                <li>Enter the 6-digit code shown above</li>
                <li>Click "Verify Email" to complete your registration</li>
            </ol>
        </div>

        <!-- Security Notice -->
        <p>
            <strong>Security Notice:</strong> If you didn't create an account with ABG Prime Builders Supplies Inc., 
            you can safely ignore this email. Your email address will not be added to our system.
        </p>

        <!-- Contact Information -->
        <p>
            If you're having trouble with the verification process or have any questions, please don't hesitate 
            to contact our customer support team.
        </p>

        <!-- Closing -->
        <p>Thank you for choosing ABG Prime Builders Supplies Inc.</p>
        <p>Sincerely,<br><em>The ABG Prime Team</em></p>

        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #815331;">
        <p style="font-size: 12px; color: #815331; text-align: center;">
            This email was automatically generated from the ABG Prime Builders Supplies Inc. verification system.
        </p>

    </div> <!-- End center container -->

</body>

</html>