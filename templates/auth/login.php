<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — ISP Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a3a6b 0%, #1d4ed8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrap {
            width: 100%;
            max-width: 420px;
            padding: 16px;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-brand .icon {
            font-size: 40px;
            display: block;
            margin-bottom: 8px;
        }
        .login-brand h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: .5px;
        }
        .login-brand p {
            color: rgba(255,255,255,.65);
            font-size: 13px;
            margin-top: 4px;
        }
        .login-card {
            background: #fff;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .login-card h2 {
            font-size: 17px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }
        .login-card .sub {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 24px;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            margin-top: 16px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,.15);
        }
        button[type=submit] {
            margin-top: 24px;
            width: 100%;
            padding: 12px;
            background: #1d4ed8;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background .2s;
        }
        button[type=submit]:hover { background: #1a3a6b; }
        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .login-hint {
            text-align: center;
            margin-top: 16px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="login-wrap">

        <div class="login-brand">
            <span class="icon">📡</span>
            <h1>NEXANET</h1>
            <p>ISP / RT RW Net Management System</p>
        </div>

        <div class="login-card">
            <h2>Masuk ke Sistem</h2>
            <p class="sub">Silakan login dengan akun administrator.</p>

            <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'invalid'): ?>
                <div class="alert-error">Username atau password salah. Coba lagi.</div>
            <?php endif; ?>

            <form method="POST" action="/isp-management/backend/auth/login.php">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="admin" required autofocus>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>

                <button type="submit">Masuk →</button>
            </form>


        </div>

    </div>
</body>
</html>
