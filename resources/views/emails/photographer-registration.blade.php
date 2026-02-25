<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Photographer Account Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .email-body {
            padding: 30px;
        }

        .welcome-section {
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .credentials-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .credential-item {
            margin-bottom: 15px;
        }

        .credential-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        .credential-value {
            font-size: 16px;
            padding: 8px 12px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: monospace;
        }

        .temporary-password {
            color: #e74c3c;
            font-weight: bold;
            font-size: 18px;
            background-color: #fff5f5;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #ffcccc;
        }

        .instructions {
            background-color: #f0f8ff;
            padding: 20px;
            border-radius: 6px;
            margin: 25px 0;
            border-left: 4px solid #3498db;
        }

        .instructions h3 {
            color: #3498db;
            margin-top: 0;
        }

        .instructions ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
        }

        .studio-info {
            background-color: #f9f7ff;
            padding: 20px;
            border-radius: 6px;
            margin: 25px 0;
            border-left: 4px solid #9b59b6;
        }

        .studio-info h3 {
            color: #9b59b6;
            margin-top: 0;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }

        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }

        .important-note {
            background-color: #fff8e1;
            border: 1px solid #ffd54f;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .user-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin: 10px 0;
            border: 3px solid #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📸 Studio Photographer Account Created</h1>
            <p>Welcome to our photography studio team!</p>
        </div>

        <div class="email-body">
            <div class="welcome-section">
                <h2>Hello {{ $photographerData['first_name'] }} {{ $photographerData['last_name'] }},</h2>
                <p>Your photographer account has been successfully created by the studio owner. You are now part of our
                    photography team!</p>
            </div>

            <div class="credentials-box">
                <h3 style="color: #667eea; margin-top: 0;">Your Account Credentials</h3>

                <div class="credential-item">
                    <span class="credential-label">Email Address (Username):</span>
                    <div class="credential-value">{{ $photographerData['email'] }}</div>
                </div>

                <div class="credential-item">
                    <span class="credential-label">Temporary Password:</span>
                    <div class="temporary-password">{{ $temporaryPassword }}</div>
                </div>

                <div class="credential-item">
                    <span class="credential-label">Position:</span>
                    <div class="credential-value">{{ $photographerData['position'] }}</div>
                </div>

                <div class="credential-item">
                    <span class="credential-label">Status:</span>
                    <div class="credential-value"
                        style="color: {{ $photographerData['status'] == 'active' ? '#27ae60' : '#e74c3c' }};">
                        {{ ucfirst($photographerData['status']) }}
                    </div>
                </div>
            </div>

            <div class="important-note">
                <strong>⚠️ Important Security Notice:</strong>
                <p>For your security, please change your temporary password immediately after logging in for the first
                    time.</p>
            </div>

            <div class="instructions">
                <h3>How to Get Started:</h3>
                <ul>
                    <li>Visit the login page at: <a href="{{ url('/auth/login') }}">{{ url('/auth/login') }}</a></li>
                    <li>Use the email and temporary password provided above</li>
                    <li>Complete your profile setup</li>
                    <li>Change your password to something more secure</li>
                    <li>Review your assigned studio and services</li>
                </ul>
            </div>

            @if (!empty($photographerData['studio_name']))
                <div class="studio-info">
                    <h3>Studio Information</h3>
                    <p><strong>Studio:</strong> {{ $photographerData['studio_name'] }}</p>
                    <p><strong>Your Position:</strong> {{ $photographerData['position'] }}</p>
                    <p><strong>Years of Experience:</strong> {{ $photographerData['years_experience'] ?? 'N/A' }} years
                    </p>
                    @if (!empty($photographerData['specialization']))
                        <p><strong>Specialization:</strong> {{ $photographerData['specialization'] }}</p>
                    @endif
                </div>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/auth/login') }}" class="cta-button">Login to Your Account</a>
            </div>

            <p style="text-align: center; color: #666;">
                If you have any questions or need assistance, please contact the studio owner or our support team.
            </p>
        </div>

        <div class="email-footer">
            <p>This is an automated message from the Studio Management System.</p>
            <p>Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Studio Management System. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
