<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างกิจกรรมใหม่ | Event System</title>
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
            max-width: 850px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border: 1px solid #e3e6f0;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 35px;
            border-bottom: 2px solid #f1f3f9;
            padding-bottom: 20px;
        }

        .header-title h1 {
            font-size: 26px;
            margin: 0;
            color: #2c3e50;
        }

        .icon-box {
            background: rgba(78, 115, 223, 0.1);
            color: var(--primary);
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 15px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-family: 'Prompt', sans-serif;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            background-color: #fcfcfc;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        /* Layout Grid สำหรับวันที่ */
        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            background: #f8f9fc;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        /* ส่วนอัปโหลดรูปภาพ */
        .upload-section {
            border: 2px dashed #d1d3e2;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            background: #fcfcfc;
            transition: 0.3s;
            cursor: pointer;
        }

        .upload-section:hover {
            border-color: var(--primary);
            background: rgba(78, 115, 223, 0.02);
        }

        .upload-icon {
            font-size: 32px;
            color: #adb5bd;
            margin-bottom: 10px;
            display: block;
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Prompt', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }

        .btn-submit:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
        }

        @media (max-width: 600px) {
            .date-grid { grid-template-columns: 1fr; }
            .container { padding: 25px; margin: 20px; }
        }
    </style>
</head>
<body>

    <?php include 'header.php' ?>

    <main class="container">
        <div class="header-title">
            <div class="icon-box">➕</div>
            <h1>สร้างกิจกรรมใหม่ของคุณ</h1>
        </div>

        <form action="/create_event" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>ชื่อกิจกรรม <span style="color: var(--danger);">*</span></label>
                <input type="text" name="event_name" required>
            </div>

            <div class="form-group">
                <label>รายละเอียดกิจกรรม</label>
                <textarea name="description"></textarea>
            </div>

            <div class="form-group">
                <label>สถานที่จัดงาน</label>
                <input type="text" name="location">
            </div>

            <div class="date-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <label>วันเริ่มกิจกรรม <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="start_date" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>วันสิ้นสุดกิจกรรม <span style="color: var(--danger);">*</span></label>
                    <input type="date" name="end_date" required>
                </div>
            </div>

            <div class="form-group" style="max-width: 300px;">
                <label>จำนวนผู้เข้าร่วมสูงสุด (คน)</label>
                <input type="number" name="max_participants" min="1" value="10">
            </div>

            <div class="form-group">
                <label>รูปภาพปกกิจกรรม <span style="color: var(--danger);">*</span></label>
                <div class="upload-section" onclick="document.getElementById('fileInput').click();">
                    <span class="upload-icon">📸</span>
                    <span style="color: #858796;">เลือกไฟล์รูปภาพที่น่าสนใจ (JPG, PNG)</span>
                    <input type="file" id="fileInput" name="event_image" accept="image/*" required style="display: none;" onchange="updateFileName(this)">
                    <div id="fileName" style="margin-top: 10px; color: var(--primary); font-weight: 600;"></div>
                </div>
            </div>

            <button type="submit" class="btn-submit"> ยืนยันการสร้างกิจกรรม</button>
        </form>
    </main>

    <?php include 'footer.php' ?>

</body>
</html>