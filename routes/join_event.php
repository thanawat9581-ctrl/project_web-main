<?php
$conn = getConnection();
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id <= 0) {
    die("กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = (int)$_POST['event_id'];
    $check = $conn->prepare("SELECT * FROM registration WHERE event_id = ? AND user_id = ?");
    $check->bind_param("ii", $event_id, $user_id);
    $check->execute();
    
    if ($check->get_result()->num_rows == 0) {
        $sql_ins = "INSERT INTO registration (event_id, user_id, register_date, status) VALUES (?, ?, NOW(), '')";
        $stmt_ins = $conn->prepare($sql_ins);
        $stmt_ins->bind_param("ii", $event_id, $user_id);
        $stmt_ins->execute();
    }
    header("Location: /join_event");
    exit;
}
$sql_list = "SELECT e.*, i.image_url, r.status as reg_status 
             FROM registration r
             JOIN events e ON r.event_id = e.event_id
             LEFT JOIN images i ON e.event_id = i.event_id
             WHERE r.user_id = ?
             ORDER BY r.register_date DESC";
             
$stmt_list = $conn->prepare($sql_list);
$stmt_list->bind_param("i", $user_id);
$stmt_list->execute();
$result = $stmt_list->get_result();

renderView('join_event', [
    'title' => 'กิจกรรมที่ฉันเข้าร่วม',
    'result' => $result
]);