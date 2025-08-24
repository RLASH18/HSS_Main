<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification | ABG Prime Builders Supplies Inc.</title>
</head>

<body style="margin:0; padding:0; background-color:#FFFFFF; font-family: 'Outfit', sans-serif;">
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
                                    <!-- Email Verification Header -->
                                    <td align="right">
                                        <span style="font-size:20px; font-weight:bold; color:#000000;">Email Verification</span><br>
                                        <span style="font-size:15px; color:#000000;">Verify your account</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:24px; background-color:#ECE5DF;">
                            <p style="color: #000000; font-size:13px; margin-top:0; margin-bottom:20px;">Thanks for registering! Use the code below:</p>
                            <table align="center" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background-color:#815331; color:#FFFFFF; font-size:22px; font-weight:bold; padding:10px 20px; border-radius:12px; letter-spacing:8px; text-align:center;">
                                        <?= htmlspecialchars($code) ?>
                                    </td>
                                </tr>
                            </table>
                            <p style="color: #000000; font-size:13px; margin-top:20px;">This code will expire in 5 minutes. If you didn't request this, you can ignore the email.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:16px 24px; background-color:#F8F9FA; text-align:center; border-top:1px solid #DDD; font-size:12px; color:#8C7D73;">
                            <p>If you have any questions, visit our page.</p>
                            <p style="color:#000000;">- The ABG Prime Builders Supplies Inc. Team</p>
                        </td>
                    </tr>

                    <!-- Bottom Bar -->
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