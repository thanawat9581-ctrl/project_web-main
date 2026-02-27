<?php
// 1. นิยามฟังก์ชัน
function insertUsers($users): bool
{
    $conn = getConnection(); // ตรวจสอบว่าไฟล์ db.php ถูก include มาก่อนหน้านี้แล้ว
    
    if ($conn === null) {
        die("Error: Database connection is null. Check if db connection file is included.");
    }

    $sql = 'INSERT INTO users (name, email, password, gender, birthdate, province) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    
    // สำคัญ: Key ใน $users[...] ต้องตรงกับตัวแปรที่รับมาจาก POST ด้านล่าง
    $stmt->bind_param('ssssss',
        $users['username'], // เดิมเป็น 'name' ซึ่งใน $users ไม่มี
        $users['email'], 
        $users['password'], 
        $users['gender'], 
        $users['birthdate'],      // เดิมเป็น 'birthdate' ซึ่งใน $users ไม่มี
        $users['province']
    );
    
    return $stmt->execute();
}

// 2. รับค่าจาก Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = [
        'username' => $_POST['username'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'gender'   => $_POST['gender'] ?? '',
        'birthdate'      => $_POST['birthdate'] ?? 0,
        'province' => $_POST['province'] ?? '',
    ];

    if (insertUsers($users)) {
        header('Location: /login');
        exit;
        renderView('reg_user', ['message' => 'เพิ่มข้อมูลเรียบร้อยแล้ว']);
    } else {
        // แสดง error จริงจาก MySQL เพื่อให้ debug ง่ายขึ้น
        global $conn;
        echo "Error: " . $conn->error;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    renderView('reg_user');
}
?>