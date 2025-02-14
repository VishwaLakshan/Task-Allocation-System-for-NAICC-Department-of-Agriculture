<?php
session_start();
include 'config_db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        // Optionally redirect to login page
        header("Location: login.php");
        exit();
    }

    // Fetch and sanitize the POST values using the null coalescing operator
    $id = $_SESSION['id']; // Get the current user's ID from session
    $taskName = $_POST['taskName'] ?? null;
    $dueDate = $_POST['dueDate'] ?? null;
    $progress = $_POST['progress'] ?? null;
    $status = $_POST['status'] ?? null;

    // Ensure all required fields are filled in before executing the query
    if ($taskName && $dueDate && $progress !== null && $status) {
        // Validate that 'progress' is an integer between 0 and 100
        if (is_numeric($progress) && $progress >= 0 && $progress <= 100) {
            // Prepare the SQL statement using named placeholders
            $stmt = $conn->prepare("INSERT INTO tasks (task, due_date, progress, status, id) VALUES (:taskName, :dueDate, :progress, :status, :id)");

            // Bind the parameters using PDO
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':taskName', $taskName);
            $stmt->bindParam(':dueDate', $dueDate);
            $stmt->bindParam(':progress', $progress, PDO::PARAM_INT); // Binding as integer
            $stmt->bindParam(':status', $status);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect back to the profile page after adding the task
                header("Location: profile.php");
                exit();
            } else {
                // Output SQL error message for debugging
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } else {
            // Handle invalid progress input
            echo "Progress must be a numeric value between 0 and 100.";
        }
    } else {
        // Handle the case where not all required fields are filled
        echo "Please fill in all the required fields.";
    }
}

// Close the connection (optional as PHP will close it automatically at the end of script execution)
$conn = null;
?>
