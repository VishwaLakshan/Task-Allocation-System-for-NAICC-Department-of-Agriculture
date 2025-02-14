<?php
session_start();
include('config_db.php');

// Check if the user is logged in and if the request has an ID
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Capture the raw POST data (since it's JSON, not form data)
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $notificationId = $data['id'];

        try {
            // Update the read status of the notification using recipient_id instead of content_id
            $stmt = $conn->prepare("UPDATE content_recipients SET read_status = 1 WHERE id = :id AND user_id = :user_id");
            $stmt->execute(['id' => $notificationId, 'user_id' => $userId]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            // Error handling if the query fails
            echo json_encode(['success' => false, 'message' => 'Failed to update notification status']);
        }
    } else {
        // If the notification ID is missing from the request
        echo json_encode(['success' => false, 'message' => 'Invalid request: Missing notification ID']);
    }
} else {
    // If the user is not logged in
    echo json_encode(['success' => false, 'message' => 'Invalid request: User not logged in']);
}
