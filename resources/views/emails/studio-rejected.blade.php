<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Studio Rejected</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #DC3545 0%, #a71d2a 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .rejection-note {
            background: #fff5f5;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #DC3545;
            border: 1px solid #f1aeb5;
        }
        .studio-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #6c757d;
        }
        .info-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .info-item i {
            margin-right: 10px;
            width: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #DC3545;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .btn:hover {
            background: #0056b3;
        }
        .important {
            color: #DC3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Studio Registration Requires Attention</h1>
            <p>Your studio registration needs modifications</p>
        </div>
        
        <div class="content">
            <p>Hello <strong>{{ $studio->user->first_name }} {{ $studio->user->last_name }}</strong>,</p>
            
            <p>We regret to inform you that your studio registration for <strong>{{ $studio->studio_name }}</strong> has been <strong>rejected</strong> by our admin team.</p>
            
            <div class="studio-info">
                <h3 style="margin-top: 0;">Studio Details:</h3>
                <div class="info-item">
                    <i>🏢</i> <strong>Studio Name:</strong> {{ $studio->studio_name }}
                </div>
                <div class="info-item">
                    <i>📊</i> <strong>Status:</strong> Rejected <span class="status-badge">REJECTED</span>
                </div>
                <div class="info-item">
                    <i>📅</i> <strong>Review Date:</strong> {{ now()->format('F d, Y') }}
                </div>
            </div>
            
            <div class="rejection-note">
                <h3 style="color: #DC3545; margin-top: 0;">📝 Rejection Reason:</h3>
                <p style="white-space: pre-wrap; background: white; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6;">
                    {{ $studio->rejection_note }}
                </p>
            </div>
            
            <p class="important">⚠️ Important: You can resubmit your studio registration after addressing the issues mentioned above.</p>
            
            <p>To fix your registration:</p>
            <ol>
                <li>Review the rejection reason above</li>
                <li>Make necessary corrections to your studio information</li>
                <li>Update any required documents</li>
                <li>Resubmit your studio registration</li>
            </ol>
            
            <div style="text-align: center;">
                <a href="{{ url('/owner/studio/create') }}" class="btn">Update Studio Registration</a>
            </div>
            
            <p>If you need clarification or have questions about the rejection reason, please contact our support team for assistance.</p>
            
            <p>Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong></p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>