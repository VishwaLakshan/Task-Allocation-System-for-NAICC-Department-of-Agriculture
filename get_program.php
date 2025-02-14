<?php
require 'db_connection.php';

$id = $_GET['id'];

$query = "SELECT * FROM timetable WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
