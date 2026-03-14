<?php
// routes/is_otp.php

function is_otp() {
    $conn = getConnection();
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    // 1. รับค่าจาก URL
    $target_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
    $event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

    $error = "";
    $success = "";

    // 2. เช็คสถานะปัจจุบันจาก Database ว่าเช็คอินไปหรือยัง
    $check_sql = "SELECT status FROM registration WHERE event_id = ? AND user_id = ?";
    $c_stmt = $conn->prepare($check_sql);
    $c_stmt->bind_param("ii", $event_id, $target_user_id);
    $c_stmt->execute();
    $current_status = $c_stmt->get_result()->fetch_object();
    
    $is_already_done = ($current_status && $current_status->status === 'checked_in');

    // 3. จัดการการส่งฟอร์ม (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$is_already_done) {
        $otp_input = trim($_POST['otp_input'] ?? '');
        
        $seconds_per_otp = 300; // 5 นาที
        $current_time = time();
        $secret_key = "MY_PROJECT_SECRET_2026"; 
        
        $slice_now = floor($current_time / $seconds_per_otp);
        $hash_now = md5($target_user_id . $event_id . $slice_now . $secret_key);
        $otp_now = str_pad(substr(number_format(hexdec(substr($hash_now, 0, 8)), 0, '', ''), -6), 6, "0", STR_PAD_LEFT);

        $slice_prev = $slice_now - 1;
        $hash_prev = md5($target_user_id . $event_id . $slice_prev . $secret_key);
        $otp_prev = str_pad(substr(number_format(hexdec(substr($hash_prev, 0, 8)), 0, '', ''), -6), 6, "0", STR_PAD_LEFT);

        if ($otp_input === $otp_now || $otp_input === $otp_prev) {
            // ✅ อัปเดตลง Database
            $update_sql = "UPDATE registration SET status = 'checked_in' WHERE event_id = ? AND user_id = ?";
            $up_stmt = $conn->prepare($update_sql);
            $up_stmt->bind_param("ii", $event_id, $target_user_id);
            $up_stmt->execute();
            
            $success = "ยืนยันสำเร็จ! ผู้เข้าร่วมเช็คอินเรียบร้อย ✅";
            $is_already_done = true;
        } else {
            $error = "รหัสไม่ถูกต้องหรือหมดอายุแล้ว ❌";
        }
    }

    // 4. ส่งค่าไปที่ Template (ใช้คีย์ให้ตรงกับที่ไฟล์ .php ในหน้าจอเรียก)
    renderView('is_otp', [
        'error' => $error,
        'success' => $success,
        'target_id' => $target_user_id, // แก้ให้ตรงกับหน้าจอ
        'event_id' => $event_id,       // แก้ให้ตรงกับหน้าจอ
        'is_done' => $is_already_done  // แก้ให้ตรงกับหน้าจอ
    ]);
}

is_otp();