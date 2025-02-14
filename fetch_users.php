<?php
header('Content-Type: application/json');
include 'db_connection.php';

$query = "SELECT id, name, email, position FROM users WHERE email != 'admin@ad.gov'";
$result = $conn->query($query);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>
