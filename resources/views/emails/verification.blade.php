<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - PHOTOGRAPHY Platform</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #007BFF;
        }
        
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        
        .welcome-text {
            font-size: 24px;
            color: #007BFF;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .subtitle {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 25px;
        }
        
        .content {
            margin: 25px 0;
        }
        
        .user-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007BFF;
        }
        
        .info-item {
            margin: 8px 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .verification-button {
            display: block;
            width: 100%;
            max-width: 250px;
            margin: 30px auto;
            padding: 14px 28px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        
        .verification-button:hover {
            background-color: #0056b3;
        }
        
        .instructions {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .instructions h4 {
            color: #856404;
            margin-top: 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #6c757d;
            font-size: 14px;
        }
        
        .expiry-notice {
            color: #dc3545;
            font-weight: 600;
            text-align: center;
            margin: 15px 0;
        }
        
        .alternative-link {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-top: 15px;
        }
        
        .alternative-link a {
            color: #007BFF;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .email-container {
                padding: 20px;
            }
            
            .welcome-text {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('assets/images/logo-black.png') }}" alt="PHOTOGRAPHY Platform Logo" class="logo">
            <h1 class="welcome-text">Welcome to PHOTOGRAPHY Platform!</h1>
            <p class="subtitle">Complete your registration by verifying your email address</p>
        </div>
        
        <div class="content">
            <p>Hello <strong>{{ $user->full_name }}</strong>,</p>
            
            <p>Thank you for registering with the PHOTOGRAPHY Platform. We're excited to have you join our community of photographers, studio owners, and clients.</p>
            
            <div class="user-info">
                <div class="info-item">
                    <span class="info-label">Full Name:</span> 
                    <span>{{ $user->first_name }} {{ $user->middle_name ? $user->middle_name . ' ' : '' }}{{ $user->last_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Account Type:</span> 
                    <span style="text-transform: capitalize;">{{ $user->role }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Registered Email:</span> {{ $user->email }}
                </div>
                <div class="info-item">
                    <span class="info-label">Registration Date:</span> {{ $user->created_at->format('F d, Y h:i A') }}
                </div>
            </div>
            
            <p>To activate your account and start using our platform, please verify your email address by clicking the button below:</p>
            
            <a href="{{ $verificationUrl }}" class="verification-button">Verify Email Address</a>
            
            <div class="expiry-notice">
                ⏰ This verification link will expire in 24 hours
            </div>
            
            <div class="instructions">
                <h4>📋 What happens after verification?</h4>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Your account will be fully activated</li>
                    <li>You can login to your dashboard</li>
                    <li>Access all platform features based on your role</li>
                </ul>
            </div>
            
            <p>If the button above doesn't work, copy and paste this link into your browser:</p>
            
            <div class="alternative-link">
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </div>
            
            <p>If you didn't create an account with PHOTOGRAPHY Platform, please ignore this email or contact our support team.</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} PHOTOGRAPHY Platform. All rights reserved.</p>
            <p>Cavite, Philippines</p>
            <p>This is an automated message, please do not reply to this email.</p>
            <p>Need help? Contact our support team through the platform.</p>
        </div>
    </div>
</body>
</html>