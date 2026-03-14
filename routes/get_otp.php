<?php
// routes/get_otp.php
function get_otp() {
    $conn = getConnection();
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }

    $user_id = (int)$_SESSION['user_id'];
    $event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

    // 1. ดึงสถานะจาก Database (เพื่อให้ตรงกับที่ is_otp อัปเดต)
    $stmt = $conn->prepare("SELECT status FROM registration WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $reg = $stmt->get_result()->fetch_object();
    
    $is_checked = ($reg && $reg->status === 'checked_in');

    // 2. สูตรคำนวณ OTP (ต้องตรงกับ is_otp เป๊ะๆ)
    $seconds_per_otp = 300; // ปรับเป็น 5 นาที (หรือ 300 วินาที) ตามไฟล์ is_otp ล่าสุด
    $current_time = time();
    $secret_key = "MY_PROJECT_SECRET_2026"; // ต้องตรงกับหน้า is_otp

    $time_slot = floor($current_time / $seconds_per_otp);
    $hash = md5($user_id . $event_id . $time_slot . $secret_key);
    $otp_code = str_pad(substr(number_format(hexdec(substr($hash, 0, 8)), 0, '', ''), -6), 6, "0", STR_PAD_LEFT);

    renderView('get_otp', [
        'otp' => $otp_code,
        'refresh_time' => $seconds_per_otp - ($current_time % $seconds_per_otp),
        'is_checked' => $is_checked,
        'event_id' => $event_id
    ]);
}
get_otp();