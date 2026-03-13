<?php
// ฟังก์ชันบันทึกกิจกรรม และคืนค่า ID ที่เพิ่งสร้าง
function insertEvent(array $events): int|bool
{
    $conn = getConnection();
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) return false;

    $sql = 'INSERT INTO events (user_id, event_name, description, location, start_date, end_date, max_participants) 
            VALUES (?, ?, ?, ?, ?, ?, ?)';
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssssi',
        $user_id, $events['event_name'], $events['description'],
        $events['location'], $events['start_date'], $events['end_date'],
        $events['max_participants']
    );

    if ($stmt->execute()) {
        $last_id = $conn->insert_id; // ดึง ID ของกิจกรรมที่เพิ่งสร้าง
        $stmt->close();
        return $last_id;
    }
    return false;
}

// ฟังก์ชันบันทึกชื่อรูปภาพลงตาราง IMAGES
function insertEventImage(int $event_id, string $image_url): bool
{
    $conn = getConnection();
    $sql = "INSERT INTO images (event_id, image_url) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("is", $event_id, $image_url);
        return $stmt->execute();
    }
    return false;
}

// ฟังก์ชันอัปเดต Role
function updateToCreator(int $user_id): bool
{
    $conn = getConnection();
    $sql = "UPDATE users SET role = 'creator' WHERE user_id = ? AND role = 'user'";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }
    return false;
}

// --- ประมวลผลเมื่อมีการส่งฟอร์ม (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $events = [
        'event_name'       => $_POST['event_name'] ?? '',
        'description'      => $_POST['description'] ?? '',
        'location'         => $_POST['location'] ?? '',
        'start_date'       => $_POST['start_date'] ?? '',
        'end_date'         => $_POST['end_date'] ?? '',
        'max_participants' => (int)($_POST['max_participants'] ?? 0),
    ];

    // 1. บันทึกกิจกรรม
    $new_event_id = insertEvent($events);

    if ($new_event_id) {
        // 2. จัดการอัปโหลดรูปภาพ
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === 0) {
            $upload_dir = 'uploads/'; // ตรวจสอบว่ามีโฟลเดอร์นี้อยู่จริง
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid('img_') . '.' . $file_ext;
            $destination = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $destination)) {
                insertEventImage((int)$new_event_id, $file_name);
            }
        }

        // 3. อัปเดตบทบาทเป็น creator
        updateToCreator((int)$_SESSION['user_id']);
        $_SESSION['role'] = 'creator';

        header('Location: /home?success=1');
        exit;
    } else {
        $error = "ไม่สามารถบันทึกข้อมูลได้";
        renderView('create_event', ['error' => $error]);
    }
} else {
    renderView('create_event');
}