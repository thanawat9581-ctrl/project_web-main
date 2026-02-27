<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | Event System</title>
    <style>
        :root {
            --primary-color: #4e73df;
            --bg-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        body {
            font-family: 'Prompt', sans-serif;
            background: #f8f9fc;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
        }

        /* ตกแต่งวงกลมจางๆ ด้านหลังให้ดูมีดีไซน์ */
        .login-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(78, 115, 223, 0.05);
            border-radius: 50%;
            top: -50px;
            right: -50px;
            z-index: -1;
        }

        h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }

        p.welcome-text {
            text-align: center;
            color: #858796;
            margin-bottom: 35px;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #5a5c69;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #eaecf4;
            border-radius: 12px;
            font-family: 'Prompt', sans-serif;
            font-size: 16px;
            transition: all 0.2s ease;
            box-sizing: border-box; /* ป้องกัน input ล้นกล่อง */
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            background: var(--bg-gradient);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
            filter: brightness(1.1);
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #858796;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* สำหรับแสดงข้อความ Error (ถ้ามี) */
        .error-msg {
            background: #fff3f3;
            color: #d9534f;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #f8d7da;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>ยินดีต้อนรับ</h1>
        <p class="welcome-text">กรุณาเข้าสู่ระบบเพื่อใช้งานต่อ</p>

        <?php if (isset($data['error'])): ?>
            <div class="error-msg">
                ⚠️ <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <form action="login" method="post">
            <div class="form-group">
                <label for="email">อีเมลผู้ใช้งาน</label>
                <input type="email" name="email" id="email" required />
            </div>

            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" name="password" id="password" required />
            </div>
            
            <button type="submit">เข้าสู่ระบบ</button>
        </form>

        <p class="register-link">
            ยังไม่มีบัญชีใช่หรือไม่? <a href="reg_user">สมัครสมาชิกที่นี่</a>
        </p>
    </div>

</body>
</html>