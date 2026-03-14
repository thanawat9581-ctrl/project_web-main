<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .otp-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 40px;
        background: #fff;
        border-radius: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        text-align: center;
        font-family: 'Sarabun', sans-serif;
    }

    /* กรณีเช็คอินสำเร็จแล้ว */
    .success-icon {
        font-size: 80px;
        color: #1cc88a;
        margin-bottom: 20px;
        animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* กล่องแสดงรหัส OTP */
    .otp-code {
        font-size: 4rem;
        font-weight: 800;
        color: #4e73df;
        letter-spacing: 8px;
        margin: 20px 0;
        text-shadow: 2px 2px 0px #f1f3f9;
    }

    /* แถบเวลาถอยหลังแบบ CSS Pure */
    .timer-wrapper {
        margin-top: 30px;
        color: #e74a3b;
        font-weight: bold;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #eee;
        border-radius: 10px;
        margin-top: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #e74a3b;
        /* วิ่งจาก 100% ไป 0% ตามเวลาที่ PHP ส่งมา */
        animation: shrink <?= $data['refresh_time'] ?>s linear forwards;
    }

    @keyframes shrink {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes scaleIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
<body>

<?php include 'header.php'; ?>

<?php if (!$data['is_checked']): ?>
    <meta http-equiv="refresh" content="<?= $data['refresh_time'] ?>">
<?php endif; ?>

<div style="max-width: 400px; margin: 40px auto; text-align: center; font-family: 'Prompt', sans-serif;">
    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <h3>รหัสยืนยันตัวตน</h3>
        <p style="color: #666;">แสดงรหัสนี้แก่เจ้าหน้าที่เพื่อเช็คอิน</p>

        <?php if ($data['is_checked']): ?>
            <div style="margin: 30px 0; padding: 20px; background: #e1f7ed; border-radius: 15px;">
                <h1 style="color: #1cc88a; margin: 0;">✅ เช็คอินแล้ว</h1>
                <p style="color: #1cc88a; margin-top: 5px; font-size: 0.9rem;">คุณได้เข้าร่วมกิจกรรมนี้เรียบร้อย</p>
            </div>

        <?php else: ?>
            <div style="margin: 30px 0;">
                <div style="font-size: 0.8rem; color: #858796; margin-bottom: 5px;">รหัสปัจจุบันของคุณคือ:</div>
                <span style="font-size: 4rem; font-weight: bold; letter-spacing: 5px; color: #4e73df; display: block;">
                    <?= $data['otp'] ?>
                </span>
            </div>
            
            <div style="color: #e74a3b; font-size: 0.85rem; background: #fff5f5; padding: 8px; border-radius: 10px;">
                ⏳ รหัสจะเปลี่ยนใหม่โดยอัตโนมัติ
            </div>
            
            <p style="font-size: 0.8rem; color: #adb5bd; margin-top: 15px;">
                (หน้านี้จะรีเฟรชตัวเองในอีก <?= $data['refresh_time'] ?> วินาที)
            </p>
            
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <a href="/join_event" style="text-decoration: none; color: #858796; font-size: 0.9rem;">กลับหน้าหลัก</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>