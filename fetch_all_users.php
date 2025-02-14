<?php
session_start();
include 'db_connection.php'; // Include your database connection file

// Assuming the user ID is stored in the session
$loggedUserId = $_SESSION['id']; // Replace with your session variable for user ID

// Query to fetch all users except the logged-in user
$query = "SELECT id, name, email, position FROM users WHERE id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch users into an array
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($users);

$stmt->close();
$conn->close();
?>
