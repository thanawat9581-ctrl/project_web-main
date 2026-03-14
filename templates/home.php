<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหากิจกรรม | Event System</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --text-muted: #858796;
            --bg-body: #f8f9fc;
        }

        body {
            font-family: 'Prompt', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            color: #4e5e6a;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .search-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            text-align: center;
        }

        .search-box {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .search-box input {
            flex-grow: 1;
            padding: 15px 20px;
            border: 2px solid #eaecf4;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Prompt', sans-serif;
        }

        .btn-search {
            padding: 15px 35px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .event-card {
            background: white;
            border-radius: 20px;
            margin-bottom: 25px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3e6f0;
            transition: 0.3s;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .event-img-container {
            width: 300px;
            height: 240px;
            flex-shrink: 0;
        }

        .event-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .event-title {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 22px;
        }

        .event-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 15px 0;
            font-size: 14px;
        }

        .count-badge {
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 12px;
            font-weight: 600;
            margin-left: 5px;
        }

        .btn-join {
            padding: 12px 25px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-active { background: var(--primary-color); color: white; }
        .btn-disabled { background: #eaecf4; color: #a1a1a1; cursor: not-allowed; }

        @media (max-width: 768px) {
            .event-card { flex-direction: column; }
            .event-img-container { width: 100%; height: 200px; }
        }
    </style>
</head>

<body>

    <?php include 'header.php' ?>

    <main class="container">
        <div class="search-container">
            <h1>สำรวจกิจกรรมที่น่าสนใจ</h1>
            <form action="/home" method="POST" class="search-box">
                <input type="text" name="keyword" placeholder="" value="<?= htmlspecialchars($_POST['keyword'] ?? '') ?>" />
                <button type="submit" class="btn-search">ค้นหา</button>
            </form>
        </div>

        <div class="event-list">
            <?php if ($data['result'] && $data['result']->num_rows > 0): ?>
                <?php while ($row = $data['result']->fetch_object()): ?>
                    <?php
                    $max = (int)$row->max_participants;
                    $current = (int)($row->current_p ?? 0);
                    $is_full = ($max > 0 && $current >= $max);
                    ?>

                    <div class="event-card">
                        <div class="event-img-container">
                            <?php if (!empty($row->image_url)): ?>
                                <img src="/uploads/<?= htmlspecialchars($row->image_url) ?>" class="event-img">
                            <?php else: ?>
                                <div class="event-img" style="background:#f1f3f9; display:flex; align-items:center; justify-content:center;">🖼️</div>
                            <?php endif; ?>
                        </div>

                        <div class="event-content">
                            <div>
                                <h3 class="event-title"><?= htmlspecialchars($row->event_name) ?></h3>
                                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.5;">
                                    <?= mb_strimwidth(htmlspecialchars($row->description), 0, 150, "...") ?>
                                </p>

                                <div class="event-meta">
                                    <div class="meta-item">📍 <strong>สถานที่:</strong> <?= htmlspecialchars($row->location) ?></div>
                                    <div class="meta-item">📅 <strong>วันที่:</strong> <?= date('d/m/Y', strtotime($row->start_date)) ?></div>
                                    <div class="meta-item">
                                        👥 <strong>เข้าร่วมแล้ว:</strong>
                                        <span style="color: <?= $is_full ? 'var(--danger-color)' : 'var(--primary-color)' ?>; font-weight: bold;">
                                            <?= $current ?> / <?= $max ?>
                                        </span>
                                        <span class="count-badge" style="background: <?= $is_full ? '#ffe5e5' : '#e1f7ed' ?>; color: <?= $is_full ? 'var(--danger-color)' : 'var(--success-color)' ?>;">
                                            <?= $is_full ? 'เต็ม' : 'ว่าง' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 15px;">
                                <?php if ($is_full): ?>
                                    <button class="btn-join btn-disabled" disabled>ที่นั่งเต็มแล้ว</button>
                                <?php else: ?>
                                    <form action="/join_event" method="POST">
                                        <input type="hidden" name="event_id" value="<?= $row->event_id ?>">
                                        <button type="submit" class="btn-join btn-active">สมัครเข้าร่วม</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 80px; background: white; border-radius: 20px; border: 2px dashed #eaecf4;">
                    <p style="color: var(--text-muted);">ไม่พบกิจกรรมที่คุณกำลังมองหา...</p>
                    <a href="/home" style="color: var(--primary-color); text-decoration: none;">ดูทั้งหมด</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php' ?>

</body>
</html>