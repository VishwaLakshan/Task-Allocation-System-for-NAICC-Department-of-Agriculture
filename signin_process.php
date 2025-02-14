<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'path/to/error.log'); // Change this to your actual log file path

// Start output buffering
ob_start();

require_once('config_db.php');
require_once('User.php');

header('Content-Type: application/json');
$response = array();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = new User();
            if ($user->loadByEmail($email)) {
                error_log("User found with email: " . $email); // Logging
                if (!$user->getVerified()) {
                    error_log("User not verified: " . $email); // Logging
                    $response['success'] = false;
                    $response['message'] = "Email not verified.";
                    $response['id'] = $user->getId();
                } else if (password_verify($password, $user->getPassword())) {
                    error_log("Password verified for user: " . $email); // Logging
                    // Perform sign-in action, set session, etc.
                    session_start();
                    $_SESSION['id'] = $user->getId();
                    $_SESSION['email'] = $user->getEmail();
                    $response['success'] = true;
                    $response['message'] = "Signed in successfully.";
                } else {
                    error_log("Incorrect password for user: " . $email); // Logging
                    $response['success'] = false;
                    $response['message'] = "Incorrect Password.";
                }
            } else {
                error_log("Email not registered: " . $email); // Logging
                $response['success'] = false;
                $response['message'] = "Email is not registered yet.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Email and Password are required.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Invalid request method.";
    }
} catch (Exception $e) {
    error_log("Error during sign-in process: " . $e->getMessage());
    $response['success'] = false;
    $response['message'] = "An error occurred. Please try again. Error: " . $e->getMessage();
}

// Clear the output buffer
ob_end_clean();

// Output the JSON response
echo json_encode($response);
?>
