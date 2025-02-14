<?php
require 'db_connection.php';

$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM trainee_courses_timetable LIMIT $offset, $limit";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['course_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['course_date']) . '</td>';
        echo '<td>' . htmlspecialchars($row['start_time']) . '</td>';
        echo '<td>' . htmlspecialchars($row['end_time']) . '</td>';
        echo '<td><button class="btn btn-warning btn-sm" onclick="editcourseschedule(' . $row['id'] . ')">Edit</button> <button class="btn btn-danger btn-sm" onclick="deletecourseschedule(' . $row['id'] . ')">Delete</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No courses found</td></tr>';
}

$conn->close();
?>
