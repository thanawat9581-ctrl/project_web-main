<?php
// routes/home.php หรือฟังก์ชันใน EventController
function getHomeEvents($keyword = '') {
    $conn = getConnection();
    
    // 1. ดึง ID ของผู้ใช้งานปัจจุบัน
    $current_user_id = $_SESSION['user_id'] ?? 0;
    $term = "%$keyword%";

    // 2. เขียน SQL หลัก: 
    // - กรองงานตัวเองออก (e.creator_id != ?)
    // - และ (กลุ่มเงื่อนไขการค้นหา ชื่อ OR วันเริ่ม OR วันสิ้นสุด)
    $sql = "SELECT e.*, i.image_url, 
        (SELECT COUNT(*) FROM registration r 
         WHERE r.event_id = e.event_id 
         AND r.status = 'checked_in') as current_p 
        FROM events e 
        LEFT JOIN images i ON e.event_id = i.event_id
        WHERE e.user_id != ?  -- เปลี่ยนชื่อคอลัมน์ตรงนี้ (สมมติว่าเป็น user_id)
        AND (e.event_name LIKE ? 
             OR e.start_date LIKE ? 
             OR e.end_date LIKE ?)
        ORDER BY e.start_date DESC";

    $stmt = $conn->prepare($sql);
    
    // 3. ผูกตัวแปร (Binding)
    // i = current_user_id (1 ตัว)
    // sss = term สำหรับค้นหา 3 จุด (ชื่อ, วันเริ่ม, วันสิ้นสุด)
    $stmt->bind_param("isss", $current_user_id, $term, $term, $term);
    
    $stmt->execute();
    return $stmt->get_result();
}

// ส่วนรับค่าจากการค้นหา
$keyword = $_POST['keyword'] ?? $_GET['keyword'] ?? '';
$result = getHomeEvents($keyword);

// ส่งข้อมูลไปที่หน้า Template
renderView('home', ['result' => $result]);