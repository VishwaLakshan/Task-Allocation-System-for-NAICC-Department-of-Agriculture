<?php
$servername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'naicc';

try {
    // Set up the PDO options array
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Set the default fetch mode to associative array
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation of prepared statements
    ];

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword, $options);

    // Connection successful
    // Uncomment the next line only for debugging purposes
    // echo "Database connection successful!";
} catch (PDOException $e) {
    // Log the error message to a file (error_log() function logs errors to a predefined log file)
    error_log("Database connection failed: " . $e->getMessage(), 0);

    // Handle the error gracefully by displaying a generic error message
    die("There was a problem connecting to the database. Please try again later.");
}
?>
