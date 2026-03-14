<?php
// routes/update_registration.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConnection();
    
    $event_id = (int)$_POST['event_id'];
    $user_id = (int)$_POST['user_id'];
    $action = $_POST['status']; // 'approved' หรือ 'rejected'

    // --- ส่วนที่แก้ไข: เช็คโควตาจากจำนวนคนที่ "เช็คอินแล้ว" เท่านั้น ---
    if ($action === 'approved') {
        $check_sql = "SELECT 
                        (SELECT max_participants FROM EVENTS WHERE event_id = ?) as max_p,
                        (SELECT COUNT(*) FROM registration WHERE event_id = ? AND status = 'checked_in') as current_p";
        
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("ii", $event_id, $event_id);
        $stmt_check->execute();
        $check = $stmt_check->get_result()->fetch_object();

        // ถ้าจำนวนคนที่ "เช็คอินแล้ว" (checked_in) ครบตามโควตาแล้ว จะไม่อนุมัติเพิ่ม
        if ($check->current_p >= $check->max_p) {
            header("Location: /details_creator?id=$event_id&status=full");
            exit;
        }
    }

    // อัปเดตสถานะใน DB (เป็น approved หรือ rejected ตามที่ส่งมา)
    $sql = "UPDATE registration SET status = ? WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $action, $event_id, $user_id);
    $stmt->execute();

    header("Location: /details_creator?id=" . $event_id);
    exit;
}