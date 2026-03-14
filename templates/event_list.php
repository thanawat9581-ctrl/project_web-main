<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการที่ฉันสร้าง | Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --bg-body: #f8f9fc;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            color: #2c3e50;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-section h1 {
            font-size: 28px;
            margin: 0;
            color: #2c3e50;
        }

        .btn-create-new {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-create-new:hover { background: #2e59d9; transform: scale(1.05); }

        /* Event Card Design */
        .event-item {
            display: flex;
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #e3e6f0;
            transition: transform 0.2s;
        }

        .event-item:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }

        .event-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 25px;
            background: #f1f3f9;
        }

        .event-info { flex: 1; }

        .event-info h3 { margin: 0 0 8px 0; font-size: 20px; color: #2c3e50; }

        /* Badge สำหรับจำนวนผู้เข้าร่วมจริง */
        .applicant-status {
            display: inline-flex;
            align-items: center;
            background: #f1f3f9;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 14px;
            color: #5a5c69;
        }

        .applicant-count { font-weight: 800; margin: 0 4px; }

        .full-badge {
            background: var(--danger);
            color: white;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            margin-left: 10px;
            font-weight: bold;
        }

        /* Action Buttons */
        .action-group { display: flex; gap: 10px; }

        .btn-action {
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: 0.2s;
        }

        .btn-manage {
            background: rgba(28, 200, 138, 0.1);
            color: var(--success);
            border: 1px solid rgba(28, 200, 138, 0.2);
        }

        .btn-manage:hover { background: var(--success); color: white; }

        .btn-edit {
            background: rgba(246, 194, 62, 0.1);
            color: #856404;
            border: 1px solid rgba(246, 194, 62, 0.2);
        }

        .btn-edit:hover { background: var(--warning); color: white; }

        @media (max-width: 600px) {
            .event-item { flex-direction: column; text-align: center; }
            .event-img { margin: 0 0 15px 0; width: 100%; height: 150px; }
            .action-group { margin-top: 15px; width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <?php include 'header.php' ?>

    <main class="container">
        <div class="header-section">
            <h1>รายการกิจกรรมที่ฉันสร้าง</h1>
            <a href="/create_event" class="btn-create-new">+ สร้างกิจกรรมใหม่</a>
        </div>

        <div class="event-list">
            <?php if ($data['result'] && $data['result']->num_rows > 0): ?>
                <?php while ($row = $data['result']->fetch_object()): 
                    // จำนวนคนที่เช็คอินสำเร็จ (ดึงมาจาก SQL Query ที่นับเฉพาะ checked_in)
                    $current = (int)$row->member_count; 
                    $max = (int)$row->max_participants;
                    $is_full = ($current >= $max);
                ?>
                    <div class="event-item">
                        <?php if (!empty($row->image_url)): ?>
                            <img src="/uploads/<?= htmlspecialchars($row->image_url) ?>" class="event-img" alt="Event Image">
                        <?php else: ?>
                            <div class="event-img" style="display:flex; align-items:center; justify-content:center; color:#adb5bd;">🖼️</div>
                        <?php endif; ?>

                        <div class="event-info">
                            <h3><?= htmlspecialchars($row->event_name) ?></h3>
                            <div class="applicant-status">
                                เข้าร่วมแล้ว: 
                                <span class="applicant-count" style="color: <?= $is_full ? 'var(--danger)' : 'var(--success)' ?>;">
                                    <?= $current ?>
                                </span> 
                                / <?= $max ?> คน
                                
                                <?php if ($is_full): ?>
                                    <span class="full-badge">เต็มแล้ว</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="action-group">
                            <a href="/details_creator?id=<?= $row->event_id ?>" class="btn-action btn-manage">
                                📋 จัดการผู้สมัคร
                            </a>
                            <a href="/edit_event?id=<?= $row->event_id ?>" class="btn-action btn-edit">
                                ✏️ แก้ไข
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 60px; background: white; border-radius: 20px; border: 2px dashed #e3e6f0;">
                    <p style="font-size: 18px; color: #858796; margin-bottom: 20px;">คุณยังไม่ได้สร้างกิจกรรมใดๆ เลย</p>
                    <a href="/create_event" class="btn-create-new">เริ่มสร้างกิจกรรมแรกของคุณ</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php' ?>

</body>
</html>