<?php
// routes/home.php

function home() {
    $conn = getConnection();
    
    // 1. ดึง ID ของคนที่ Login อยู่ออกมา
    $current_user_id = $_SESSION['user_id'] ?? 0;
    
    $keyword = $_REQUEST['keyword'] ?? ''; 
    
    // 2. ปรับ SQL: เพิ่มเงื่อนไข WHERE e.user_id != ? (เจ้าของต้องไม่เห็นงานตัวเอง)
    $sql = "SELECT e.*, i.image_url, 
            (SELECT COUNT(*) FROM registration r 
             WHERE r.event_id = e.event_id 
             AND r.status = 'approved') as current_p 
            FROM EVENTS e 
            LEFT JOIN IMAGES i ON e.event_id = i.event_id
            WHERE e.user_id != ?"; // <-- เงื่อนไขหลัก
    
    if (!empty($keyword)) {
        // ถ้ามีการค้นหา ต้องใช้ AND เชื่อมเพื่อให้เงื่อนไข "ไม่ใช่งานตัวเอง" ยังคงอยู่
        $sql .= " AND (e.event_name LIKE ? OR e.description LIKE ? OR e.location LIKE ?)";
        $stmt = $conn->prepare($sql);
        $term = "%$keyword%";
        // ผูกตัวแปร: user_id ตัวแรก, ตามด้วย keyword 3 ตัว
        $stmt->bind_param("isss", $current_user_id, $term, $term, $term);
    } else {
        // ถ้าไม่ได้ค้นหา ก็แค่กรองงานของตัวเองออก
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $current_user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    renderView('home', [
        'result' => $result,
        'keyword' => $keyword // ส่ง keyword กลับไปแสดงในช่อง input ด้วย
    ]);
}

home();