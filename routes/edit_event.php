<?php
function updateEvent(int $id, array $data): bool {
    $conn = getConnection();
    $sql = 'UPDATE events SET event_name = ?, description = ?, location = ?, start_date = ?, end_date = ?, max_participants = ? WHERE event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssi', $data['event_name'], $data['description'], $data['location'], $data['start_date'], $data['end_date'], $data['max_participants'], $id);
    return $stmt->execute();
}

function updateEventImage(int $event_id, string $image_url): bool {
    $conn = getConnection();
    $check = $conn->query("SELECT * FROM images WHERE event_id = $event_id");
    if ($check->num_rows > 0) {
        $sql = "UPDATE images SET image_url = ? WHERE event_id = ?";
    } else {
        $sql = "INSERT INTO images (image_url, event_id) VALUES (?, ?)";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $image_url, $event_id);
    return $stmt->execute();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: /event_list'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventData = [
        'event_name'       => $_POST['event_name'] ?? '',
        'description'      => $_POST['description'] ?? '',
        'location'         => $_POST['location'] ?? '',
        'start_date'       => $_POST['start_date'] ?? '',
        'end_date'         => $_POST['end_date'] ?? '',
        'max_participants' => $_POST['max_participants'] ?? 0
    ];

    if (updateEvent($id, $eventData)) {
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === 0) {
            $upload_dir = 'uploads/';
            $file_ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
            $new_file_name = uniqid('edit_') . '.' . $file_ext;
            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $upload_dir . $new_file_name)) {
                updateEventImage($id, $new_file_name);
            }
        }
        header('Location: /event_list');
        exit;
    }
}

$conn = getConnection();
$sql = "SELECT e.*, i.image_url FROM events e LEFT JOIN images i ON e.event_id = i.event_id WHERE e.event_id = $id";
$event = $conn->query($sql)->fetch_object();

renderView('edit_event', ['event' => $event]);