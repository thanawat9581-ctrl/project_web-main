<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขกิจกรรม | Event System</title>
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --bg-body: #f8f9fc;
            --border-color: #eaecf4;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            color: #4e5e6a;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h1 {
            color: #2c3e50;
            font-size: 26px;
            margin-bottom: 30px;
            border-left: 5px solid var(--primary);
            padding-left: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Prompt', sans-serif;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        }

        /* Image Preview Section */
        .image-preview-container {
            background: #fcfcfc;
            border: 2px dashed var(--border-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        .current-img {
            max-width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        /* Grid for Date & Participants */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-group {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-save {
            background: var(--success);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save:hover { background: #17a673; transform: translateY(-2px); }

        .btn-cancel {
            color: #858796;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-cancel:hover { color: #e74a3b; }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <?php include 'header.php' ?>

    <main class="container">
        <h1>แก้ไขรายละเอียดกิจกรรม</h1>

        <?php if (isset($data['event'])): 
            $row = $data['event']; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label>ชื่อกิจกรรม</label>
                    <input type="text" name="event_name" value="<?= htmlspecialchars($row->event_name) ?>" required placeholder="ระบุชื่อกิจกรรมของคุณ">
                </div>

                <div class="image-preview-container">
                    <label>รูปภาพปัจจุบัน</label>
                    <?php if (!empty($row->image_url)): ?>
                        <img src="/uploads/<?= htmlspecialchars($row->image_url) ?>" class="current-img">
                    <?php else: ?>
                        <p style="color: #adb5bd; margin: 20px 0;">🖼️ ยังไม่มีรูปภาพประกอบกิจกรรม</p>
                    <?php endif; ?>
                    
                    <div style="margin-top: 10px;">
                        <label style="font-size: 14px; color: var(--primary);">อัปโหลดรูปภาพใหม่:</label>
                        <input type="file" name="event_image" accept="image/*">
                    </div>
                </div>

                <div class="form-group">
                    <label>รายละเอียดกิจกรรม</label>
                    <textarea name="description" rows="4" placeholder="อธิบายกิจกรรมของคุณที่นี่..."><?= htmlspecialchars($row->description) ?></textarea>
                </div>

                <div class="form-group">
                    <label>สถานที่จัดงาน</label>
                    <input type="text" name="location" value="<?= htmlspecialchars($row->location) ?>" placeholder="ระบุสถานที่ หรือลิงก์ Google Maps">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>วันเริ่มกิจกรรม</label>
                        <input type="date" name="start_date" value="<?= date('Y-m-d', strtotime($row->start_date)) ?>">
                    </div>
                    <div class="form-group">
                        <label>วันสิ้นสุดกิจกรรม</label>
                        <input type="date" name="end_date" value="<?= date('Y-m-d', strtotime($row->end_date)) ?>">
                    </div>
                </div>

                <div class="form-group" style="max-width: 300px;">
                    <label>จำนวนผู้เข้าร่วมสูงสุด (คน)</label>
                    <input type="number" name="max_participants" value="<?= $row->max_participants ?>" min="1">
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-save"> บันทึกการแก้ไข</button>
                    <a href="/event_list" class="btn-cancel">ยกเลิกและกลับ</a>
                </div>
            </form>

        <?php else: ?>
            <div style="text-align: center; padding: 40px;">
                <p style="font-size: 18px; color: #e74a3b;">ไม่พบข้อมูลกิจกรรมที่ต้องการแก้ไข</p>
                <a href="/event_list" class="btn-save" style="display: inline-block; text-decoration: none;">กลับไปยังรายการ</a>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php' ?>

</body>
</html>