<?php
require 'db_connection.php';

$query = "SELECT COUNT(*) as count FROM timetable";
$result = $conn->query($query);
$row = $result->fetch_assoc();

echo $row['count'];

$conn->close();
?>
