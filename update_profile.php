<?php
session_start();
include('config_db.php'); // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "User is not logged in.";
    exit();
}

// Get the user ID from the session
$id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $division = $_POST['division'];

    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $profile_picture = $_FILES['profile_picture']['name'];
        $targetDir = "uploads/";

        // Ensure the uploads directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Generate a unique filename to avoid overwriting
        $uniqueFileName = uniqid() . '_' . basename($profile_picture);
        $targetFile = $targetDir . $uniqueFileName;

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFile)) {
            // Update profile picture in database
            $stmt = $conn->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
            $stmt->execute(['profile_picture' => $uniqueFileName, 'id' => $id]);
        } else {
            echo "Failed to upload file.";
        }
    }

    // Update user profile in the database
    $stmt = $conn->prepare("UPDATE users SET name = :name, position = :position, phone = :phone, location = :location, division = :division WHERE id = :id");
    if ($stmt->execute(['name' => $name, 'position' => $position, 'phone' => $phone, 'location' => $location, 'division' => $division, 'id' => $id])) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->errorInfo();
    }
}
?>
