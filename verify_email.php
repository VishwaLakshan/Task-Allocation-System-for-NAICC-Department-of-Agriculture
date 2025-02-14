<?php
require_once('config_db.php');
require_once('User.php');

header('Content-Type: application/json'); // Set the response content type to JSON

$response = array(); // Initialize a response array

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'], $_POST['verification_code'])) {
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $verification_code = trim($_POST['verification_code']); // Trim to remove whitespace

            $user = new User();
            if ($user->loadById($id)) {
                $stored_verification_code = $user->getVerificationCode();
                // Check if stored verification code matches user input after trimming
                if ($stored_verification_code === $verification_code) {
                    if ($user->verified()) { // Assuming verify() marks the user as verified
                        $response['success'] = true;
                        $response['message'] = "Email verification successful.";
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Failed to mark user as verified.";
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Invalid verification code.";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "User not found.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Missing parameters.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Invalid request method.";
    }
} catch (Exception $e) {
    error_log("Error during email verification: " . $e->getMessage());
    $response['success'] = false;
    $response['message'] = "An error occurred. Please try again. Error: " . $e->getMessage();
}

echo json_encode($response);
?>
