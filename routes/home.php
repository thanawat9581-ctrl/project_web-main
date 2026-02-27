<?php
// routes/home.php

function home() {
    $conn = getConnection();
    
    // รับค่า Keyword ไม่ว่าจะมาจากการ Search (POST) หรือการส่งผ่าน URL (GET)
    $keyword = $_REQUEST['keyword'] ?? ''; 
    
    // SQL: ดึงข้อมูลกิจกรรม + รูปภาพ + นับเฉพาะคนที่ status = 'approved'
    // เราใช้ alias 'current_p' เพื่อให้ตรงกับในไฟล์ View (HTML)
    $sql = "SELECT e.*, i.image_url, 
            (SELECT COUNT(*) FROM registration r 
             WHERE r.event_id = e.event_id 
             AND r.status = 'approved') as current_p 
            FROM EVENTS e 
            LEFT JOIN IMAGES i ON e.event_id = i.event_id";
    
    if (!empty($keyword)) {
        // เพิ่มเงื่อนไขค้นหา
        $sql .= " WHERE e.event_name LIKE ? OR e.description LIKE ? OR e.location LIKE ?";
        $stmt = $conn->prepare($sql);
        $term = "%$keyword%";
        $stmt->bind_param("sss", $term, $term, $term);
    } else {
        // ดึงทั้งหมด
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // เรนเดอร์หน้า home และส่งตัวแปร $result ไปให้ View
    renderView('home', ['result' => $result]);
}

// เรียกใช้ฟังก์ชันเพื่อให้ทำงาน
home();