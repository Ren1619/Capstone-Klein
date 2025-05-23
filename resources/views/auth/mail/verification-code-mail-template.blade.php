<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Two-Factor Authentication Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .code-panel {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Two-Factor Authentication Verification</h1>
        </div>

        <p>Hello {{ $account->first_name }},</p>

        <p>Your verification code is:</p>

        <div class="code-panel">
            {{ $code }}
        </div>

        <p>This code will expire in 15 minutes.</p>

        <p>If you did not attempt to log in, please ignore this email or contact support if you believe someone is
            trying to access your account.</p>

        <div class="footer">
            <p>Thanks,<br>
                {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>