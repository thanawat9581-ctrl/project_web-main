<?php
function user_profile() {
    $conn = getConnection();

    $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($user_id <= 0) {
        die("Error: ไม่พบ ID ผู้ใช้งานใน URL (URL ต้องเป็น ?id=xxx)");
    }

    $sql = "SELECT user_id, name, email, gender, province, birthdate FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_object();

    if (!$member) {
        die("Error: ไม่พบข้อมูลสมาชิก ID: " . $user_id . " ในฐานข้อมูล");
    }

    renderView('user_profile', [
        'member' => $member
    ]);
}
user_profile();