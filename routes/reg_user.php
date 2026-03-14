<?php
function insertUsers($users): bool
{
    $conn = getConnection();
    
    if ($conn === null) {
        die("Error: Database connection is null. Check if db connection file is included.");
    }

    $sql = 'INSERT INTO users (name, email, password, gender, birthdate, province) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param('ssssss',
        $users['username'], 
        $users['email'], 
        $users['password'], 
        $users['gender'], 
        $users['birthdate'],   
        $users['province']
    );
    
    return $stmt->execute();
}

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
        global $conn;
        echo "Error: " . $conn->error;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    renderView('reg_user');
}
?>