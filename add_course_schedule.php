<?php
require 'db_connection.php';

// Get POST data
$course_name = $_POST['course_name'];
$course_date = $_POST['course_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

// Prepare SQL statement
$query = "INSERT INTO trainee_courses_timetable (course_name, course_date, start_time, end_time) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die('MySQL prepare error: ' . htmlspecialchars($conn->error));
}

// Bind parameters (only three parameters)
$stmt->bind_param("ssss", $course_name, $course_date, $start_time, $end_time);

// Execute the statement
$stmt->execute();

// Check for success
if ($stmt->affected_rows > 0) {
    echo 'success';
} else {
    // Optional: include more detailed error information for debugging
    echo 'error: ' . htmlspecialchars($stmt->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
