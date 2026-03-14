<?php
function deleteEvent(int $id): bool
{
    $conn = getConnection();
    $sql = 'delete from events where event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}
if (!isset($_GET['event_id'])) {
    header('Location: /event_list');
    exit;
} else {
    $id = (int)$_GET['event_id'];
    $result = deleteEvent($id);
    if ($result > 0) {
        header('Location: /event_list');
    } else {
        renderView('400', ['message' => 'Something went wrong! This is regarding the course withdrawal process.']);
    }
}