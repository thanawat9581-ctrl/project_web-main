<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้สมัคร | Event System</title>
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
            color: #4e5e6a;
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Card ส่วนหัวกิจกรรม */
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

        .header-img {
            flex: 1;
            max-width: 320px;
        }

        .header-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header-info {
            flex: 2;
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

        .info-item {
            font-size: 15px;
        }

        .info-item strong {
            color: #2c3e50;
        }

        /* Table Design */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3e6f0;
        }

        .table-container h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th {
            background-color: #f8f9fc;
            color: #4e73df;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #e3e6f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f3f9;
            vertical-align: middle;
        }

        tr:hover {
            background-color: #fcfcfc;
        }

        /* Status Badges */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
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

        /* Action Buttons */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-family: 'Prompt', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .btn-approve {
            background: var(--success);
            color: white;
        }

        .btn-approve:hover {
            background: #17a673;
            transform: scale(1.05);
        }

        .btn-reject {
            background: #fff;
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-reject:hover {
            background: var(--danger);
            color: white;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .event-header-card {
                flex-direction: column;
            }

            .header-img {
                max-width: 100%;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
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
                        <div class="info-item"><strong>👥 ผู้สมัคร:</strong> <?= $data['participants']->num_rows ?> / <?= $data['event']->max_participants ?> คน</div>
                        <div class="info-item"><strong>📅 เริ่ม:</strong> <?= date('d/m/Y', strtotime($data['event']->start_date)) ?></div>
                        <div class="info-item"><strong>📅 สิ้นสุด:</strong> <?= date('d/m/Y', strtotime($data['event']->end_date)) ?></div>
                    </div>
                    <p style="color: #858796; font-size: 14px; line-height: 1.6; border-top: 1px solid #f1f3f9; padding-top: 10px;">
                        <?= nl2br(htmlspecialchars($data['event']->description)) ?>
                    </p>
                </div>
            </div>

            <div class="table-container">
                <h3>👥 รายชื่อผู้สมัครเข้าร่วม</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ชื่อผู้สมัคร</th>
                            <th style="text-align: center;">สถานะ</th>
                            <th style="text-align: right;">จัดการการอนุมัติ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data['participants'] && $data['participants']->num_rows > 0): ?>
                            <?php while ($user = $data['participants']->fetch_object()): ?>
                                <tr>
                                    <td style="font-weight: 500; color: #2c3e50;">
                                        <a href="/user_profile?id=<?= (int)$user->user_id ?>">
                                            <?= htmlspecialchars($user->name) ?>
                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($user->status === 'approved'): ?>
                                            <span class="badge badge-success">✅ อนุมัติแล้ว</span>
                                        <?php elseif ($user->status === 'rejected'): ?>
                                            <span class="badge badge-danger">❌ ปฏิเสธ</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">⏳ รอการตรวจสอบ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="/update_registration" method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?= (int)$data['event']->event_id ?>">
                                            <input type="hidden" name="user_id" value="<?= (int)$user->user_id ?>">

                                            <?php if ($user->status !== 'approved'): ?>
                                                <button type="submit" name="status" value="approved" class="btn btn-approve">
                                                    อนุมัติ
                                                </button>
                                            <?php endif; ?>

                                            <button type="submit" name="status" value="rejected"
                                                onclick="return confirm('ยืนยันการปฏิเสธหรือลบผู้สมัครรายนี้?')"
                                                class="btn btn-reject" style="margin-left: 5px;">
                                                ลบชื่อ
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align:center; padding: 50px; color: #adb5bd;">ยังไม่มีผู้สมัครในขณะนี้</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="/event_list" class="back-link">← กลับไปหน้ารายการกิจกรรมของฉัน</a>
    </main>

    <?php include 'footer.php' ?>

</body>

</html>