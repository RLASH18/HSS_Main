<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <div>
        <div>
            <h2>Email Verification</h2>
            <p>
                Thanks for registering! Please use the code below to verify your email:
            </p>
            <div>
                <?= htmlspecialchars($code) ?>
            </div>
            <p>
                This code will expire in 30 minutes. If you didn't request this, you can ignore the email.
            </p>
        </div>
    </div>
</body>

</html>