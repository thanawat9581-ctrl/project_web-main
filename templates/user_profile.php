<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* 📌 Profile Theme - Custom CSS */
    :root {
        --primary-blue: #4e73df;
        --bg-light: #f8f9fc;
        --text-dark: #2c3e50;
        --text-muted: #858796;
        --white: #ffffff;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .profile-body {
        background-color: var(--bg-light);
        font-family: 'Prompt', 'Sarabun', sans-serif;
        min-height: 80vh;
        display: flex;
        align-items: center;
        padding: 40px 0;
    }

    .profile-container {
        width: 100%;
        max-width: 480px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .profile-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow);
        padding: 40px;
        text-align: center;
        border: 1px solid #edf2f7;
    }

    /* วงกลม Avatar */
    .avatar-circle {
        width: 110px;
        height: 110px;
        background: linear-gradient(135deg, var(--primary-blue), #224abe);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        margin: 0 auto 20px;
        box-shadow: 0 8px 15px rgba(78, 115, 223, 0.3);
    }

    .user-name {
        font-size: 1.6rem;
        color: var(--text-dark);
        margin-bottom: 5px;
        font-weight: 700;
    }

    .user-email {
        color: var(--text-muted);
        font-size: 1rem;
        margin-bottom: 25px;
    }

    /* รายละเอียดข้อมูล */
    .info-section {
        border-top: 1px solid #f1f3f9;
        padding-top: 25px;
        text-align: left;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .info-label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .info-value {
        color: var(--text-dark);
        font-weight: 600;
    }

    /* ปุ่มย้อนกลับ */
    .btn-container {
        margin-top: 30px;
    }

    .btn-custom-back {
        width: 100%;
        padding: 12px;
        background-color: #f1f3f9;
        color: var(--text-dark);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        font-size: 1rem;
    }

    .btn-custom-back:hover {
        background-color: #e2e6ea;
        transform: translateY(-2px);
    }

    /* ข้อความแจ้งเตือนถ้าไม่พบข้อมูล */
    .error-box {
        text-align: center;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: var(--shadow);
    }
</style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="profile-body">
    <div class="profile-container">
        <?php if (isset($data['member'])): ?>
            <div class="profile-card">
                <div class="avatar-circle">
                    <?= mb_substr($data['member']->name, 0, 1) ?>
                </div>
                
                <h2 class="user-name"><?= htmlspecialchars($data['member']->name) ?></h2>
                <p class="user-email"><?= htmlspecialchars($data['member']->email) ?></p>

                <div class="info-section">
                    <div class="info-row">
                        <span class="info-label">📍 จังหวัด:</span>
                        <span class="info-value"><?= htmlspecialchars($data['member']->province ?? 'ไม่ระบุ') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">🚻 เพศ:</span>
                        <span class="info-value">
                            <?php 
                                if($data['member']->gender == 'M') echo 'ชาย';
                                elseif($data['member']->gender == 'F') echo 'หญิง';
                                else echo 'ไม่ระบุ';
                            ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">🎂 วันเกิด:</span>
                        <span class="info-value">
                            <?= ($data['member']->birthdate) ? date('d/m/Y', strtotime($data['member']->birthdate)) : '-' ?>
                        </span>
                    </div>
                </div>

                <div class="btn-container">
                    <button onclick="history.back()" class="btn-custom-back">← ย้อนกลับ</button>
                </div>
            </div>
        <?php else: ?>
            <div class="error-box">
                <p style="color: var(--text-muted); margin-bottom: 20px;">ไม่พบข้อมูลสมาชิกท่านนี้ในระบบ</p>
                <button onclick="history.back()" class="btn-custom-back">กลับไปหน้าหลัก</button>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>