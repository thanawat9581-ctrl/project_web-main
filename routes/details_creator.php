<?php


function getEventDetailData($conn, $id) {

    $sql_event = "SELECT e.*, i.image_url FROM events e 
                  LEFT JOIN images i ON e.event_id = i.event_id 
                  WHERE e.event_id = ?";
    $stmt_event = $conn->prepare($sql_event);
    $stmt_event->bind_param("i", $id);
    $stmt_event->execute();
    $event = $stmt_event->get_result()->fetch_object();

    $sql_reg = "SELECT u.user_id, u.name, u.gender, u.province, 
                TIMESTAMPDIFF(YEAR, u.birthdate, CURDATE()) as age,
                r.register_date, r.status 
                FROM registration r
                INNER JOIN users u ON r.user_id = u.user_id
                WHERE r.event_id = ?
                ORDER BY r.register_date DESC";
    $stmt_reg = $conn->prepare($sql_reg);
    $stmt_reg->bind_param("i", $id);
    $stmt_reg->execute();
    $participants = $stmt_reg->get_result();

    return ['event' => $event, 'list' => $participants];
}

$conn = getConnection();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("ไม่ระบุรหัสกิจกรรม");

$result = getEventDetailData($conn, $id);

renderView('details_creator', [
    'title' => 'จัดการผู้เข้าร่วมกิจกรรม',
    'event' => $result['event'],
    'participants' => $result['list'],
    'event_id' => $id 
]);