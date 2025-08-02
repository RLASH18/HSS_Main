<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px;">
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; text-align: center;">
            <h2 style="color: #333;">Email Verification</h2>
            <p style="color: #555;">
                Thanks for registering! Please use the code below to verify your email:
            </p>
            <div style="background-color: #007bff; color: white; padding: 15px; border-radius: 5px; font-size: 24px; font-weight: bold; letter-spacing: 4px; margin: 20px 0;">
                <?= htmlspecialchars($code) ?>
            </div>
            <p style="color: #888; font-size: 14px;">
                This code will expire in 30 minutes. If you didn't request this, you can ignore the email.
            </p>
        </div>
    </div>
</body>

</html>