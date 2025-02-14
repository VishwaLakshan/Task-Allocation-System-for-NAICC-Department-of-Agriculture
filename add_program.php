<?php
include('config_db.php');

// Get POST data and validate (optional but recommended)
$program_name = isset($_POST['program_name']) ? trim($_POST['program_name']) : null;
$media_type = isset($_POST['media_type']) ? trim($_POST['media_type']) : null;
$channel_name = isset($_POST['channel_name']) ? trim($_POST['channel_name']) : null;
$program_date = isset($_POST['program_date']) ? trim($_POST['program_date']) : null;
$program_time = isset($_POST['program_time']) ? trim($_POST['program_time']) : null;

try {
    // Ensure all required fields are present
    if ($program_name && $media_type && $channel_name && $program_date && $program_time) {
        // Prepare SQL statement
        $query = "INSERT INTO timetable (program_name, media_type, channel_name, program_date, program_time) 
                  VALUES (:program_name, :media_type, :channel_name, :program_date, :program_time)";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':program_name', $program_name);
        $stmt->bindParam(':media_type', $media_type);
        $stmt->bindParam(':channel_name', $channel_name);
        $stmt->bindParam(':program_date', $program_date);
        $stmt->bindParam(':program_time', $program_time);

        // Execute the statement
        $stmt->execute();

        // Check for success
        if ($stmt->rowCount() > 0) {
            echo 'success';
        } else {
            echo 'error: No rows affected';
        }
    } else {
        echo 'error: Missing required fields';
    }
} catch (PDOException $e) {
    // Log the error and show a generic message
    error_log("Database error: " . $e->getMessage(), 0);
    echo 'error: Database operation failed';
}

// PDO automatically closes the connection when the script ends
?>
