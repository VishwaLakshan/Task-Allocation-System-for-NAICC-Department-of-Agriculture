<?php
require 'db_connection.php';

$id = $_POST['id'];

$query = "DELETE FROM trainee_courses_timetable WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
