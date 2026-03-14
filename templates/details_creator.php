<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้สมัคร | Event System</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --bg-body: #f8f9fc;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: var(--bg-body);
            color: #4e5e6a;
            margin: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .event-header-card {
            display: flex;
            gap: 30px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            border: 1px solid #e3e6f0;
        }

        .header-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
        }

        .header-info h2 {
            margin: 0 0 15px 0;
            font-size: 26px;
            color: #2c3e50;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3e6f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th {
            background-color: #f8f9fc;
            color: var(--primary);
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #e3e6f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f3f9;
        }

        .btn-otp {
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-otp:hover {
            background: #2e59d9;
            transform: translateY(-2px);
        }

        /* Badge Styles */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-checked {
            background: #1cc88a;
            color: white;
        }

        .badge-success {
            background: #e1f7ed;
            color: var(--success);
        }

        .badge-danger {
            background: #ffe5e5;
            color: var(--danger);
        }

        .badge-warning {
            background: #fff4e5;
            color: var(--warning);
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .btn-approve {
            background: var(--success);
            color: white;
        }

        .btn-reject {
            background: #fff;
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .back-link {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>

    <main class="container">
        <?php if ($data['event']): ?>
            <div class="event-header-card">
                <div class="header-img">
                    <?php if ($data['event']->image_url): ?>
                        <img src="/uploads/<?= htmlspecialchars($data['event']->image_url) ?>">
                    <?php else: ?>
                        <div style="width: 100%; height: 200px; background: #f1f3f9; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #adb5bd;">ไม่มีรูปภาพ</div>
                    <?php endif; ?>
                </div>
                <div class="header-info">
                    <h2><?= htmlspecialchars($data['event']->event_name) ?></h2>
                    <div class="info-grid">
                        <div class="info-item"><strong>📍 สถานที่:</strong> <?= htmlspecialchars($data['event']->location) ?></div>

                        <?php
                        $checked_in_count = 0;
                        if ($data['participants'] && $data['participants']->num_rows > 0) {
                            // วนลูปนับจำนวน
                            while ($p = $data['participants']->fetch_assoc()) { // ใช้ fetch_assoc เพื่อดึงเป็น array
                                if ($p['status'] === 'checked_in') {
                                    $checked_in_count++;
                                }
                            }
                            // 💡 สำคัญมาก: ต้องรีเซ็ต pointer กลับไปที่แถวแรก เพื่อให้ while loop ของตารางข้างล่างทำงานได้
                            $data['participants']->data_seek(0);
                        }
                        ?>
                        <div class="info-item"><strong>✅ เข้าร่วมแล้ว:</strong> <?= $checked_in_count ?> / <?= $data['event']->max_participants ?> คน</div>

                        <div class="info-item"><strong>📅 เริ่ม:</strong> <?= date('d/m/Y', strtotime($data['event']->start_date)) ?></div>
                        <div class="info-item"><strong>📅 สิ้นสุด:</strong> <?= date('d/m/Y', strtotime($data['event']->end_date)) ?></div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <h3>👥 รายชื่อผู้สมัครเข้าร่วม</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อผู้สมัคร</th>
                            <th style="text-align: center;">สถานะ</th>
                            <th style="text-align: center;">จัดการเช็คอิน</th>
                            <th style="text-align: right;">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data['participants'] && $data['participants']->num_rows > 0): ?>
                            <?php while ($user = $data['participants']->fetch_object()): ?>
                                <tr>
                                    <td style="font-weight: 500; color: #2c3e50;">
                                        <a href="/user_profile?id=<?= (int)$user->user_id ?>" style="text-decoration:none; color:inherit;">
                                            <?= htmlspecialchars($user->name) ?>
                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($user->status === 'checked_in'): ?>
                                            <span class="badge badge-checked">✅ เข้าร่วมแล้ว</span>
                                        <?php elseif ($user->status === 'approved'): ?>
                                            <span class="badge badge-success">✅ อนุมัติแล้ว</span>
                                        <?php elseif ($user->status === 'rejected'): ?>
                                            <span class="badge badge-danger">❌ ปฏิเสธ</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">⏳ รอตรวจสอบ</span>
                                        <?php endif; ?>
                                    </td>

                                    <td style="text-align: center;">
                                        <?php if ($user->status === 'checked_in'): ?>
                                            <span style="color: var(--success); font-size: 13px; font-weight: bold;">เช็คอินเรียบร้อย</span>
                                        <?php elseif ($user->status === 'approved'): ?>
                                            <a href="/is_otp?user_id=<?= $user->user_id ?>&event_id=<?= $data['event']->event_id ?>" class="btn-otp">
                                                ตรวจรหัส OTP
                                            </a>
                                        <?php else: ?>
                                            <span style="color:#ccc; font-size:12px;">รอการอนุมัติ</span>
                                        <?php endif; ?>
                                    </td>

                                    <td style="text-align: right;">
                                        <form action="/update_registration" method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?= (int)$data['event']->event_id ?>">
                                            <input type="hidden" name="user_id" value="<?= (int)$user->user_id ?>">

                                            <?php if ($user->status !== 'approved' && $user->status !== 'checked_in'): ?>
                                                <button type="submit" name="status" value="approved" class="btn btn-approve">อนุมัติ</button>
                                            <?php endif; ?>

                                            <?php if ($user->status !== 'checked_in'): ?>
                                                <button type="submit" name="status" value="rejected"
                                                    class="btn btn-reject" style="margin-left: 5px;">ปฏิเสธ</button>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align:center; padding: 50px; color: #adb5bd;">ยังไม่มีผู้สมัครในขณะนี้</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div style="margin-top: 30px; display: flex; justify-content: space-between;">
            <a href="/event_list" class="back-link">← กลับไปหน้ารายการกิจกรรมของฉัน</a>
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>