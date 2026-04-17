<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
            color: white;
            padding: 32px;
            text-align: center;
        }
        .email-header .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .email-header .tagline {
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 40px 32px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        .content {
            color: #4B5563;
            font-size: 15px;
            margin-bottom: 24px;
        }
        .content p {
            margin-bottom: 12px;
        }
        .highlight-box {
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            text-align: center;
            padding: 24px;
            border-radius: 12px;
            margin: 24px 0;
        }
        .info-box {
            background-color: #F3F4F6;
            border-radius: 12px;
            padding: 16px 20px;
            margin: 24px 0;
            font-size: 14px;
            color: #6B7280;
        }
        .info-box.warning {
            background-color: #FEF3C7;
            border-left: 4px solid #F59E0B;
            color: #92400E;
        }
        .info-box.success {
            background-color: #D1FAE5;
            border-left: 4px solid #10B981;
            color: #065F46;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            margin: 16px 0;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .email-footer {
            background-color: #F9FAFB;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #E5E7EB;
        }
        .email-footer p {
            font-size: 12px;
            color: #9CA3AF;
            margin-bottom: 4px;
        }
        .divider {
            height: 1px;
            background-color: #E5E7EB;
            margin: 24px 0;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        .detail-table td {
            padding: 12px 0;
            border-bottom: 1px solid #E5E7EB;
            font-size: 14px;
        }
        .detail-table td:first-child {
            color: #6B7280;
            width: 40%;
        }
        .detail-table td:last-child {
            color: #1F2937;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <div class="logo">{{ config('app.name') }}</div>
                @if(isset($headerTagline))
                    <div class="tagline">{{ $headerTagline }}</div>
                @endif
            </div>
            
            <div class="email-body">
                @if(isset($greeting))
                    <div class="greeting">{{ $greeting }}</div>
                @endif
                
                <div class="content">
                    {{ $slot }}
                </div>
            </div>
            
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
                <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            </div>
        </div>
    </div>
</body>
</html>
