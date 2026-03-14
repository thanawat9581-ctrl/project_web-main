<?php
function getMyEvents() {
    $conn = getConnection();
    $user_id = $_SESSION['user_id'] ?? 0;
    

    $sql = "SELECT e.*, i.image_url, 
            (SELECT COUNT(*) FROM registration r 
             WHERE r.event_id = e.event_id 
             AND r.status = 'checked_in') as member_count
            FROM events e 
            LEFT JOIN images i ON e.event_id = i.event_id
            WHERE e.user_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

$result = getMyEvents();
renderView('event_list', ['result' => $result]);