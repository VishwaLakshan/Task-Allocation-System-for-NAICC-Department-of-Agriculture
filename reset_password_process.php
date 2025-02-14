<?php
require_once('config_db.php');
require_once('User.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $reset_token = $_POST['reset_token'];
    $newPassword = $_POST['newPassword'];

    $user = new User();
    if ($user->loadByEmail($email)) {
        if ($user->getResetToken() == $reset_token) {
            $user->setPassword($newPassword);
            $user->update();
            $response = ['success' => true, 'message' => 'Password reset successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Invalid token.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Email not registered.'];
    }
}

echo json_encode($response);