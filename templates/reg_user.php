<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างบัญชีใหม่ | Event System</title>
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --success-color: #1cc88a;
            --bg-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            --text-color: #4e5e6a;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background: #f8f9fc;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-color);
        }
        .reg-card {
            background: white;
            width: 100%;
            max-width: 480px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .reg-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: var(--bg-gradient);
        }

        h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }

        p.subtitle {
            text-align: center;
            color: #858796;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #5a5c69;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eaecf4;
            border-radius: 10px;
            font-family: 'Prompt', sans-serif;
            font-size: 15px;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary-color);
            background-color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
        }
        .btn-register {
            width: 100%;
            background: var(--bg-gradient);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234e73df' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 18px;
        }
    </style>
</head>
<body>

    <div class="reg-card">
        <h1>ลงทะเบียน</h1>
        <p class="subtitle">เริ่มต้นสร้างประสบการณ์ใหม่กับเรา</p>

        <form action="reg_user" method="POST">
            <div class="form-group">
                <label>ชื่อผู้ใช้งาน (Username)</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>อีเมล (Email)</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>รหัสผ่าน (Password)</label>
                <input type="password" name="password" required>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>เพศ</label>
                    <select name="gender">
                        <option value="male">ชาย</option>
                        <option value="female">หญิง</option>
                        <option value="other">อื่นๆ</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>วันเกิด</label>
                    <input type="date" name="birthdate" required>
                </div>
            </div>

            <div class="form-group">
                <label>จังหวัด</label>
                <input type="text" name="province">
            </div>

            <button type="submit" class="btn-register">สร้างบัญชีผู้ใช้งาน</button>
        </form>

        <div class="footer-links">
            มีบัญชีอยู่แล้ว? <a href="/login">เข้าสู่ระบบที่นี่</a>
        </div>
    </div>

</body>
</html>