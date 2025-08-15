<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification | ABG Prime Builders Supplies Inc.</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Outfit', sans-serif; margin: 0; padding: 0; background-color: #FFFFFF;">
    <!-- Email container -->
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
                <h1 style="margin: 0; font-size: 20px; font-weight: bold; color: #000000;">Email Verification</h1>
                <span style="font-size: 15px; color: #000000;">Verify your account</span>
            </div>
        </div>
        <!-- Body -->
        <div style="background-color: #ECE5DF; padding: 24px;">
            <h2 style="font-size: 16px; font-weight: bold; margin-top: 0;">Email Verification</h2>
            <p style="font-size: 13px; margin-bottom: 20px;">Thanks for registering! Please use the code below to verify your email:</p>
            <div style="display: flex; justify-content: center; align-items: center;">
                <div style="background-color: #815331; color: #FFFFFF; font-size: 22px; font-weight: bold; padding: 10px 20px; border-radius: 12px; display: inline-block; letter-spacing: 8px; margin-bottom: 20px;">
                    <?= htmlspecialchars($code) ?>
                </div>
            </div>
            <p style="font-size: 13px; margin-bottom: 10px;">This code will expire in 30 minutes. If you didn't request this, you can ignore the email.</p>
        </div>
        <!-- Footer -->
        <div style="background-color: #F8F9FA; padding: 16px 24px; text-align: center; border-top: 1px solid #DDD; font-size: 12px; color: #8C7D73;">
            <p>If you have any questions, visit our page.</p>
            <p style="color: #000000;">- The ABG Prime Builders Supplies Inc. Team</p>
        </div>
        <div style="background-color: #815331; color: #FFFFFF; font-size: 12px; padding: 10px; text-align: center;">
            &copy; 2025 <strong style="color: #FFFFFF;">ABG Prime Builders Supplies Inc.</strong> - Powered by ABG. Building Better, Together.
        </div>
    </div>
</body>

</html>