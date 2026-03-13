<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กิจกรรมที่ฉันเข้าร่วม</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
            color: #4e5e6a;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }

        hr {
            border: 0;
            border-top: 1px solid #e3e6f0;
            margin-bottom: 30px;
        }

        /* Card กิจกรรม */
        .event-card {
            background: #ffffff;
            border: 1px solid #e3e6f0;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: flex-start;
            transition: transform 0.2s ease;
        }

        .event-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* ส่วนรูปภาพ */
        .event-image-wrapper {
            flex-shrink: 0;
            margin-right: 25px;
        }

        .event-image {
            width: 200px;
            height: 130px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #eaecf4;
        }

        .no-image {
            width: 200px;
            height: 130px;
            background: #f1f3f9;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b7c0cd;
            font-size: 14px;
            border: 1px solid #eaecf4;
        }

        /* ส่วนเนื้อหา */
        .event-content {
            flex-grow: 1;
        }

        .event-title {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 20px;
            font-weight: 600;
        }

        .event-info {
            margin: 5px 0;
            color: #858796;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Badge สถานะ */
        .status-badge {
            margin-top: 12px;
            padding: 6px 16px;
            border-radius: 30px;
            display: inline-block;
            font-weight: 600;
            font-size: 13px;
        }

        .status-joined {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #664d03;
            border: 1px solid #ffecb5;
        }

        /* ลิงก์รายละเอียด */
        .detail-link {
            display: inline-block;
            margin-top: 15px;
            color: #4e73df;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .detail-link:hover {
            text-decoration: underline;
        }

        /* หน้าว่าง */
        .empty-state {
            text-align: center;
            padding: 60px;
            background: #fff;
            border-radius: 15px;
            border: 2px dashed #e3e6f0;
        }

        .btn-home {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #4e73df;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-home:hover {
            background: #2e59d9;
        }
    </style>
</head>

<body>

    <?php include 'header.php' ?>

    <main class="container">
        <h1>กิจกรรมที่ฉันเข้าร่วม</h1>
        <hr>

        <div class="event-list">
            <?php
            $result = $data['result'] ?? null;
            if ($result instanceof mysqli_result && $result->num_rows > 0):
                while ($row = $result->fetch_object()):
                    // กำหนด Class สถานะ
                    $status_class = 'status-pending';
                    $status_text = '⏳ กำลังรอการอนุมัติ';

                    if ($row->reg_status === 'approved') {
                        $status_class = 'status-joined';
                        $status_text = '✅ อนุมัติแล้ว';
                    } elseif ($row->reg_status === 'rejected') {
                        $status_class = 'status-rejected';
                        $status_text = '❌ ปฏิเสธการเข้าร่วม';
                    }


            ?>
                    <div class="event-card">
                        <div class="event-image-wrapper">
                            <?php if (!empty($row->image_url)): ?>
                                <img src="/uploads/<?= htmlspecialchars($row->image_url) ?>" class="event-image" alt="Event Image">
                            <?php else: ?>
                                <div class="no-image">🖼️ ไม่มีรูปภาพ</div>
                            <?php endif; ?>
                        </div>

                        <div class="event-content">
                            <h3 class="event-title"><?= htmlspecialchars($row->event_name) ?></h3>
                            <p class="event-info">
                                <strong>📍 สถานที่:</strong> <?= htmlspecialchars($row->location) ?><br>
                                <strong>⏰ เวลา:</strong> <?= date('d/m/Y', strtotime($row->start_date)) ?> - <?= date('d/m/Y', strtotime($row->end_date)) ?>
                            </p>

                            <div class="status-badge <?= $status_class ?>">
                                <?= $status_text ?>
                            </div>
                            <?php if ($row->reg_status === 'approved'): ?>
                                    <a href="/get_otp?event_id=<?= (int)$row->event_id ?>" class="btn-otp">
                                        🔑 รับรหัส OTP
                                    </a>
                            <?php endif; ?>

                            <div>
                                <a href="/event_detail?id=<?= $row->event_id ?>" class="detail-link">ดูรายละเอียดงานนี้ →</a>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <div class="empty-state">
                    <p style="font-size: 18px; color: #858796;">คุณยังไม่ได้ลงทะเบียนเข้าร่วมกิจกรรมใดๆ</p>
                    <a href="/home" class="btn-home">ไปสำรวจกิจกรรมที่น่าสนใจ</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php' ?>

</body>

</html>