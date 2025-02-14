<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Log start of script execution
file_put_contents('php://stderr', "texteditor.php script started\n");

$host = 'localhost';
$db = 'naicc';
$user = 'root';
$pass = '';

try {
    $dsn = "mysql:host=$host;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Log database connection success
    file_put_contents('php://stderr', "Database connected\n");

    $data = json_decode(file_get_contents('php://input'), true);

    // Log received data
    file_put_contents('php://stderr', "Received data: " . print_r($data, true) . "\n");

    if (isset($data['content']) && isset($data['userIds']) && isset($data['senderId'])) {
        $content = $data['content'];
        $userIds = $data['userIds'];
        $senderId = $data['senderId'];

        // Insert the content into the contents table
        $stmt = $pdo->prepare('INSERT INTO contents (content) VALUES (:content)');
        $stmt->execute(['content' => $content]);

        // Get the ID of the inserted content
        $contentId = $pdo->lastInsertId();

        // Log successful insertion
        file_put_contents('php://stderr', "Content inserted with ID: " . $contentId . "\n");

        // Insert into content_recipients table
        $recipientsStmt  = $pdo->prepare('INSERT INTO content_recipients (content_id, user_id, sender_id) VALUES (:content_id, :user_id, :sender_id)');

        foreach ($userIds as $userId) {
            $recipientsStmt->execute(['content_id' => $contentId, 'user_id' => $userId, 'sender_id' => $senderId]);
        }

        // Log successful insertion of recipients
        file_put_contents('php://stderr', "Recipients added for content ID: " . $contentId . "\n");

        echo json_encode(['success' => true, 'message' => 'Content shared successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Content or user IDs not provided.']);
    }
} catch (PDOException $e) {
    // Log the error
    file_put_contents('php://stderr', "Error: " . $e->getMessage() . "\n");
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
