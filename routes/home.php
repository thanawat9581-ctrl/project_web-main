<?php
function getHomeEvents($keyword = '') {
    $conn = getConnection();
    $current_user_id = $_SESSION['user_id'] ?? 0;
    $term = "%$keyword%";
    $sql = "SELECT e.*, i.image_url, 
        (SELECT COUNT(*) FROM registration r 
         WHERE r.event_id = e.event_id 
         AND r.status = 'checked_in') as current_p 
        FROM events e 
        LEFT JOIN images i ON e.event_id = i.event_id
        WHERE e.user_id != ?  
        AND (e.event_name LIKE ? 
             OR e.start_date LIKE ? 
             OR e.end_date LIKE ?)
        ORDER BY e.start_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $current_user_id, $term, $term, $term); 
    $stmt->execute();
    return $stmt->get_result();
}
$keyword = $_POST['keyword'] ?? $_GET['keyword'] ?? '';
$result = getHomeEvents($keyword);

renderView('home', ['result' => $result]);