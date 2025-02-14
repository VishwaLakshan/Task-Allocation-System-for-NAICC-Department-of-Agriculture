<?php
session_start(); // Start the session
include 'config_db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if task_id is provided
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];

        // Debugging output
        error_log("Task ID received for deletion: " . $task_id);

        // Prepare the SQL statement with a placeholder
        $stmt = $conn->prepare("DELETE FROM tasks WHERE task_id = :task_id");

        // Bind the task ID parameter to the statement
        $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

        // Execute the query and check if successful
        if ($stmt->execute()) {
            error_log("Task with ID $task_id deleted successfully.");
            echo json_encode(['success' => true, 'message' => 'Task deleted successfully.']);
        } else {
            error_log("Error deleting task with ID $task_id: " . implode(", ", $stmt->errorInfo()));
            echo json_encode(['success' => false, 'message' => 'Error deleting task.']);
        }
    } else {
        error_log("Task ID not provided.");
        echo json_encode(['success' => false, 'message' => 'Task ID not provided.']);
    }
} else {
    error_log("Invalid request method.");
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
