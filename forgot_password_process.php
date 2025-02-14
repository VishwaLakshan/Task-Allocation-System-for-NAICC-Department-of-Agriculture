<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config_db.php');
require_once('User.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $user = new User();
    if ($user->loadByEmail($email)) {
        if ($user->sendResetToken()) {
            $response = ['success' => true, 'message' => 'Reset link sent to your email.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to send reset link.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Email not registered.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

// Always set the content type to JSON
header('Content-Type: application/json');
echo json_encode($response);
