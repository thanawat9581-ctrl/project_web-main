<?php
function checkLogin(string $email, string $password): ?array // เปลี่ยนให้คืนค่าเป็น array ข้อมูล user
{
    $conn = getConnection();
    // 1. ดึงทั้ง password และ user_id ออกมาพร้อมกัน
    $sql = 'SELECT user_id, password FROM users WHERE email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // 2. ถ้า password ถูก ให้คืนค่าข้อมูล user ทั้งหมดออกมา
        if (password_verify($password, $row['password'])) {
            return $row;
        }
    }
    return null;
}

// ประมวลผลก่อนแสดงผลหน้า
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 3. รับค่า user มาจากฟังก์ชัน
    $user = checkLogin($email, $password);
    if ($user) {
        // 4. ตอนนี้ $user['user_id'] จะมีค่าแล้ว!
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_email'] = $email;
        $_SESSION['is_logged_in'] = true;

        header('Location: /home');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }
} else {
    renderView('login');
}
