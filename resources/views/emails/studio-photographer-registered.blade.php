<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Photographer Account Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a6fa5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .info-box {
            background-color: white;
            border-left: 4px solid #4a6fa5;
            padding: 15px;
            margin: 20px 0;
        }
        .credentials {
            background-color: #e8f4fc;
            border: 1px solid #b6d4fe;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .important {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            background-color: #4a6fa5;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Studio Photographer Account Registered</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $photographer->first_name }} {{ $photographer->last_name }},</p>
        
        <p>Your photographer account has been successfully registered with <strong>{{ $studio->studio_name }}</strong>.</p>
        
        <div class="info-box">
            <h3>Studio Information:</h3>
            <p><strong>Studio:</strong> {{ $studio->studio_name }}</p>
            <p><strong>Studio Owner:</strong> {{ $owner->first_name }} {{ $owner->last_name }}</p>
            <p><strong>Your Position:</strong> {{ $photographerRecord->position }}</p>
        </div>
        
        <div class="credentials">
            <h3>Your Login Credentials:</h3>
            <p><strong>Email:</strong> {{ $photographer->email }}</p>
            <p><strong>Temporary Password:</strong> <span class="important">{{ $password }}</span></p>
        </div>
        
        <p class="important">Important: Please change your password immediately after your first login.</p>
        
        <p>To access your account, please visit:</p>
        <a href="{{ url('/auth/login') }}" class="button">Login to Your Account</a>
        
        <p>After logging in, you can:</p>
        <ul>
            <li>Update your profile information</li>
            <li>Change your password</li>
            <li>View your assigned services</li>
            <li>Check your schedule</li>
        </ul>
        
        <p>If you have any questions or need assistance, please contact the studio owner:</p>
        <p><strong>{{ $owner->first_name }} {{ $owner->last_name }}</strong><br>
        Email: {{ $owner->email }}<br>
        Phone: {{ $owner->mobile_number }}</p>
        
        <p>Best regards,<br>
        <strong>{{ $studio->studio_name }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ $studio->studio_name }}. All rights reserved.</p>
    </div>
</body>
</html>