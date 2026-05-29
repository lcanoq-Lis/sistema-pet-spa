<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Spa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; background: #F0F5F0; display: flex; align-items: center; justify-content: center; padding: 20px; }

        .auth-wrap { width: 100%; max-width: 420px; }

        .auth-card {
            background: #fff; border-radius: 20px;
            border: 1px solid #DDE8DD; padding: 36px;
        }

        .auth-logo { text-align: center; margin-bottom: 28px; }
        .auth-logo-icon {
            width: 54px; height: 54px; background: #1B5E20;
            border-radius: 14px; display: flex; align-items: center;
            justify-content: center; font-size: 26px;
            margin: 0 auto 12px;
        }
        .auth-logo h1 { font-size: 20px; font-weight: 700; color: #1A2E1A; margin-bottom: 4px; }
        .auth-logo p { font-size: 13px; color: #6B8F6B; }

        .alert { padding: 11px 14px; border-radius: 9px; font-size: 13px; margin-bottom: 16px; border-left: 3px solid; }
        .alert-success { background: #E8F5E9; color: #1B5E20; border-color: #2E7D32; }
        .alert-error { background: #FFEBEE; color: #B71C1C; border-color: #EF5350; }

        .field { margin-bottom: 16px; }
        .field-label { display: block; font-size: 13px; font-weight: 600; color: #1A2E1A; margin-bottom: 6px; }
        .field-input {
            width: 100%; border: 1.5px solid #DDE8DD; border-radius: 10px;
            padding: 11px 14px; font-size: 14px; outline: none;
            color: #1A2E1A; background: #fff;
            transition: border-color 0.18s; font-family: inherit;
        }
        .field-input:focus { border-color: #2E7D32; }
        .link-muted { font-size: 12px; color: #6B8F6B; text-decoration: none; }
        .link-muted:hover { color: #2E7D32; }

        .btn-auth {
            width: 100%; background: #2E7D32; color: #fff;
            border: none; border-radius: 10px; padding: 12px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: inherit; transition: background 0.18s;
            margin-bottom: 16px;
        }
        .btn-auth:hover { background: #1B5E20; }

        .auth-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 8px 0 16px; color: #9EB09E; font-size: 12px;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; border-top: 1px solid #DDE8DD;
        }

        .btn-google {
            width: 100%; display: flex; align-items: center; justify-content: center;
            gap: 10px; border: 1.5px solid #DDE8DD; border-radius: 10px;
            padding: 11px; font-size: 14px; font-weight: 500; color: #1A2E1A;
            text-decoration: none; background: #fff; transition: background 0.18s;
            margin-bottom: 20px;
        }
        .btn-google:hover { background: #F0F5F0; }

        .auth-footer { text-align: center; font-size: 13px; color: #6B8F6B; }
        .auth-footer a { color: #2E7D32; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { color: #1B5E20; }

        .strength-bar { display: flex; gap: 4px; margin-top: 8px; }
        .strength-bar-segment { height: 4px; flex: 1; border-radius: 4px; background: #DDE8DD; transition: background 0.2s; }
        .strength-text { font-size: 11px; color: #6B8F6B; margin-top: 4px; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>