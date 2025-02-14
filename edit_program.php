<?php
include('config_db.php');

try {
    // Check if the required POST data is set and valid
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = (int)$_POST['id']; // Cast to integer for safety

        // Other POST data
        $program_name = $_POST['program_name'];
        $media_type = $_POST['media_type'];
        $channel_name = $_POST['channel_name'];
        $program_date = $_POST['program_date'];
        $program_time = $_POST['program_time'];

        // Prepare the SQL UPDATE statement
        $query = "UPDATE timetable SET program_name = :program_name, media_type = :media_type, channel_name = :channel_name, program_date = :program_date, program_time = :program_time WHERE id = :id";
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':program_name', $program_name, PDO::PARAM_STR);
        $stmt->bindParam(':media_type', $media_type, PDO::PARAM_STR);
        $stmt->bindParam(':channel_name', $channel_name, PDO::PARAM_STR);
        $stmt->bindParam(':program_date', $program_date, PDO::PARAM_STR);
        $stmt->bindParam(':program_time', $program_time, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                echo 'success';
            } else {
                // No record found with that ID or no change made
                echo 'error: No changes were made or record not found.';
            }
        } else {
            // Handle execution error
            echo 'error: Failed to execute the query.';
        }
    } else {
        // Invalid ID input
        echo 'error: Invalid ID.';
    }
} catch (PDOException $e) {
    // Handle PDO exceptions
    echo 'error: ' . htmlspecialchars($e->getMessage());
}

// Close the database connection
$conn = null; // Set to null to close the connection
?>
