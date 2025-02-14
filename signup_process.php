<?php

use PHPMailer\PHPMailer\Exception;

require_once('config_db.php');
require_once('User.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $type = $_POST['type'] ?? '';

    try {
        $user = new User();
        $user->loadByEmail($email);

        if ($user->getId() != null) {
            $response['success'] = false;
            $response['message'] = "Email address already registered. Please use a different email.";
        } elseif ($password !== $confirm_password) {
            $response['success'] = false;
            $response['message'] = "Password and Confirm Password do not match. Please try again.";
        } elseif (!isStrongPassword($password)) {
            $response['success'] = false;
            $response['message'] = "Your password must be at least 8 characters long, contain at least one number, symbol and have a mixture of uppercase and lowercase letters.";
        } else {
            // Generate verification code
            $verification_code = generateVerificationCode();

            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT)); // Hash the password
            $user->setUserType($type); // Set the user type
            $user->setVerificationCode($verification_code); // Set verification code

            $result = $user->signUp();

            if ($result) {
                $response['success'] = true;
                $response['message'] = "Registration successful.";
                $response['user_id'] = $user->getId();
            } else {
                $response['success'] = false;
                $response['message'] = "Registration failed due to a database error.";
            }
        }
    } catch (Exception $e) {
        error_log("Error during user registration: " . $e->getMessage());
        $response['success'] = false;
        $response['message'] = "An error occurred. Please try again later. Error: " . $e->getMessage();
    }

    // Log the response
    error_log("Response: " . json_encode($response));
    echo json_encode($response);
}

function isStrongPassword($password) {
    $minLength = 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialChar = preg_match('/[^A-Za-z0-9]/', $password);

    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}

function generateVerificationCode() {
    return bin2hex(random_bytes(6)); // Example: 12-character hexadecimal code
}
?>
