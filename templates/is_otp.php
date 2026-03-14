<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'header.php'; ?>

<div style="max-width: 400px; margin: 50px auto; font-family: 'Sarabun', sans-serif;">
    <div style="background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center;">
        
        <h2 style="color: #4e73df;">ตรวจรหัสเข้างาน</h2>
        <p style="color: #858796;">กำลังยืนยันตัวตน User ID: <strong>#<?= $data['target_id'] ?></strong></p>
        
        <hr style="border: 0; border-top: 1px solid #f1f3f9; margin: 20px 0;">

        <?php if ($data['success']): ?>
            <div style="color: #1cc88a; background: #e1f7ed; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold;">
                <?= $data['success'] ?>
            </div>
            <a href="/details_creator?id=<?= $data['event_id'] ?>" style="display: block; background: #4e73df; color: #fff; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: bold;">กลับหน้าจัดการกิจกรรม</a>

        <?php elseif ($data['is_done']): ?>
            <div style="color: #f6c23e; background: #fef9e7; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                ⚠️ ผู้เข้าร่วมคนนี้เช็คอินเรียบร้อยแล้ว
            </div>
            <a href="javascript:history.back()" style="color: #858796;">ย้อนกลับ</a>

        <?php else: ?>
            <?php if ($data['error']): ?>
                <div style="color: #e74a3b; margin-bottom: 15px; font-weight: bold;"><?= $data['error'] ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="otp_input" maxlength="6" placeholder="000000" required 
                       style="width: 100%; font-size: 3rem; text-align: center; letter-spacing: 10px; padding: 10px; border: 2px solid #ddd; border-radius: 15px; margin-bottom: 20px; outline: none;">
                
                <button type="submit" style="width: 100%; padding: 15px; background: #1cc88a; color: #fff; border: none; border-radius: 15px; font-size: 1.1rem; font-weight: bold; cursor: pointer;">
                    ยืนยันการเช็คอิน
                </button>
            </form>
            <p style="margin-top: 20px;"><a href="javascript:history.back()" style="color: #858796; text-decoration: none;">ยกเลิก</a></p>
        <?php endif; ?>

    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>