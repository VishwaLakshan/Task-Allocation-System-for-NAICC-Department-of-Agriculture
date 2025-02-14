<?php
session_start();
include('config_db.php'); // Include your database configuration

$id = $_SESSION['id'] ?? null;
$notifications = [];

if ($id) {
    try {
        // Query to fetch notifications for the logged-in user
        $query = "SELECT contents.content, contents.created_at, content_recipients read_status, users.name AS sender_name
        FROM content_recipients 
        JOIN contents ON content_recipients.content_id = contents.id 
        JOIN users ON contents.sender_id = users.id
        WHERE content_recipients.user_id = :user_id
        ORDER BY contents.created_at DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all notifications
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return notifications as JSON response
        echo json_encode($notifications);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Unable to retrieve notifications']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}
