<?php
require 'db_connection.php';

$id = $_POST['id'];
$course_name = $_POST['course_name'];
$course_date = $_POST['course_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$query = "UPDATE trainee_courses_timetable SET course_name=?, course_date=?, start_time=?, end_time=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $course_name, $course_date, $start_time, $end_time, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
