<?php
session_start();
include 'config_db.php'; // Include your database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in (if necessary)
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }

    // Fetch and sanitize POST values
    $task_id = $_POST['task_id'] ?? null; // Ensure task_id is obtained
    $taskName = $_POST['taskName'] ?? null;
    $dueDate = $_POST['dueDate'] ?? null;
    $progress = $_POST['progress'] ?? null;
    $status = $_POST['status'] ?? null;

    // Ensure all required fields are filled
    if ($task_id && $taskName && $dueDate && $progress !== null && $status) {
        // Validate that 'progress' is an integer between 0 and 100
        if (is_numeric($progress) && $progress >= 0 && $progress <= 100) {
            // Prepare the SQL statement with placeholders
            $stmt = $conn->prepare("UPDATE tasks SET task = :taskName, due_date = :dueDate, progress = :progress, status = :status WHERE task_id = :task_id");

            // Bind the parameters to the statement
            $stmt->bindParam(':taskName', $taskName, PDO::PARAM_STR);
            $stmt->bindParam(':dueDate', $dueDate, PDO::PARAM_STR);
            $stmt->bindParam(':progress', $progress, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

            // Execute the query and check if successful
            if ($stmt->execute()) {
                // Redirect back to the main page after editing
                header("Location: profile.php");
                exit();
            } else {
                // Show the error message
                echo "Error executing query: " . implode(", ", $stmt->errorInfo());
            }
        } else {
            echo "Progress must be a numeric value between 0 and 100.";
        }
    } else {
        echo "Please fill in all the required fields.";
    }
}
?>
