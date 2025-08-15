<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - ABG Prime</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #F8F9FA;
            margin: 0;
            padding: 20px 0;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background-color: #F8F9FA;
            padding: 30px 40px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .logo-fallback {
            width: 60px;
            height: 60px;
            background-color: #815331;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
        
        .logo-text {
            text-align: left;
        }
        
        .logo-text h1 {
            color: #815331;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .logo-text .subtitle {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
            font-weight: 400;
        }
        
        .header-title {
            color: #333333;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        
        .header-subtitle {
            color: #6c757d;
            font-size: 16px;
            margin: 5px 0 0 0;
            font-weight: 400;
        }
        
        .email-body {
            background-color: #ECE5DF;
            padding: 40px;
        }
        
        .content-section {
            text-align: left;
            margin-bottom: 30px;
        }
        
        .content-title {
            color: #333333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .content-text {
            color: #333333;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .verification-code {
            text-align: center;
            margin: 30px 0;
        }
        
        .code-button {
            background-color: #815331;
            color: white;
            padding: 15px 40px;
            border-radius: 25px;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(129, 83, 49, 0.3);
        }
        
        .expiry-text {
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
            margin-top: 30px;
        }
        
        .email-footer {
            background-color: #ffffff;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer-text {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .footer-signature {
            color: #333333;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        
        .footer-copyright {
            background-color: #815331;
            color: white;
            padding: 20px;
            font-size: 13px;
            margin: -30px -40px -30px -40px;
        }
        
        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0 10px;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 20px;
            }
            
            .logo-section {
                flex-direction: column;
                gap: 15px;
            }
            
            .logo-text h1 {
                font-size: 24px;
                text-align: center;
            }
            
            .header-title {
                font-size: 20px;
            }
            
            .content-title {
                font-size: 20px;
            }
            
            .code-button {
                padding: 12px 30px;
                font-size: 20px;
            }
            
            .footer-copyright {
                margin: -20px -20px -20px -20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="email-header">
            <div class="logo-section">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" onerror="this.parentElement.innerHTML='<div class=\'logo-fallback\'>ABG</div>'">
                    </div>
                    <div class="logo-text">
                        <h1>ABG Prime</h1>
                        <p class="subtitle">Builders Supplies Inc.</p>
                    </div>
                </div>
                <div>
                    <h2 class="header-title">Email Verification</h2>
                    <p class="header-subtitle">Verify your account</p>
                </div>
            </div>
        </div>

        <!-- Body Section -->
        <div class="email-body">
            <div class="content-section">
                <h2 class="content-title">Email Verification</h2>
                <p class="content-text">
                    Thanks for registering! Please use the code below to verify your email:
                </p>
                
                <div class="verification-code">
                    <div class="code-button">
                        <?= htmlspecialchars($code) ?>
                    </div>
                </div>
                
                <p class="expiry-text">
                    This code will expire in 30 minutes. If you didn't request this, you can ignore the email.
                </p>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="email-footer">
            <p class="footer-text">
                If you have any questions, feel free to reply to this email.
            </p>
            <p class="footer-signature">
                - The ABG Prime Builders Inc. Team
            </p>
            
            <div class="footer-copyright">
                © 2025 ABG Prime Builders Supplies Inc. - Powered by ABG. Building Better, Together.
            </div>
        </div>
    </div>
</body>

</html>