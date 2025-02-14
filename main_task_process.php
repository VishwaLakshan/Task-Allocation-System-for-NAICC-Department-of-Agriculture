<?php
include('config_db.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Check what is being received
    var_dump($_POST); // Debug line to check POST data

    // Get the form data
    $main_task_name = $_POST['main_task_name'] ?? null; 
    $description = $_POST['description'] ?? null;
    $authority = $_POST['authority'] ?? null; 
    $due_date = $_POST['due_date'] ?? null;
    $actual_due_date = $_POST['actual_due_date'] ?? null; 
    $priority = $_POST['priority'] ?? null;

    // Validation: Ensure required fields are provided
    $errors = [];
    if (empty($main_task_name)) {
        $errors[] = 'Main task name is required.';
    }

    // Proceed if no validation errors
    if (empty($errors)) {
        // Prepare the SQL query to insert the main task
        $insertMainTaskQuery = "
            INSERT INTO main_task (main_task_name, description, authority, due_date, actual_due_date, priority) 
            VALUES (:main_task_name, :description, :authority, :due_date, :actual_due_date, :priority)";

        $stmt = $conn->prepare($insertMainTaskQuery);

        // Bind parameters
        $stmt->bindParam(':main_task_name', $main_task_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':authority', $authority);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':actual_due_date', $actual_due_date);
        $stmt->bindParam(':priority', $priority);

        // Execute the statement
        if ($stmt->execute()) {
            header('Location: dashboard.php?success=1'); 
            exit();
        } else {
            echo "Error adding main task: " . implode(", ", $stmt->errorInfo());
        }
    } else {
        // If there are errors, display them
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
