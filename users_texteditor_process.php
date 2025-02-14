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
    // Establish PDO connection
    $dsn = "mysql:host=$host;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Log database connection success
    file_put_contents('php://stderr', "Database connected\n");

    // Retrieve input data
    $data = json_decode(file_get_contents('php://input'), true);

    // Log received data
    file_put_contents('php://stderr', "Received data: " . print_r($data, true) . "\n");

    // Check for required data fields
    if (isset($data['content'], $data['userIds'], $data['senderId'])) {
        $content = $data['content'];
        $userIds = $data['userIds'];
        $senderId = $data['senderId'];

        // Insert the content into the contents table
        $stmt = $pdo->prepare('INSERT INTO contents (content) VALUES (:content)');
        $stmt->execute(['content' => $content]);

        // Log successful content insertion
        file_put_contents('php://stderr', "Content inserted with ID: " . $pdo->lastInsertId() . "\n");

        // Get the ID of the inserted content
        $contentId = $pdo->lastInsertId();

        // Prepare statement for inserting into content_recipients table
        $insertStmt = $pdo->prepare('INSERT INTO content_recipients (content_id, user_id, sender_id) VALUES (:content_id, :user_id, :sender_id)');

        // Insert recipient data for each user ID
        foreach ($userIds as $userId) {
            $insertStmt->execute([
                'content_id' => $contentId,
                'user_id' => $userId,
                'sender_id' => $senderId
            ]);

            // Log each insertion
            file_put_contents('php://stderr', "Inserted into content_recipients: content_id = $contentId, user_id = $userId, sender_id = $senderId\n");
        }

        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error for missing required fields
        echo json_encode(['success' => false, 'message' => 'Invalid input: Missing content, userIds, or senderId']);
    }
} catch (PDOException $e) {
    // Log and return PDO errors
    file_put_contents('php://stderr', 'PDOException: ' . $e->getMessage() . "\n");
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Exception $e) {
    // Log and return general exceptions
    file_put_contents('php://stderr', 'Exception: ' . $e->getMessage() . "\n");
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
