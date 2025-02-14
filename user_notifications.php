<?php
session_start();
include('config_db.php'); // This file should contain the PDO connection setup

// Flag for login status
$not_logged_in = false;

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    $not_logged_in = true;
}

// Fetch user notifications from the database
$id = $_SESSION['id'] ?? null;
$notifications = [];

if (!$not_logged_in) {
    try {
        // Query to fetch notifications for the logged-in user by joining content_recipients, contents, and users tables
        $query = "
            SELECT 
                contents.content, 
                contents.created_at, 
                content_recipients.read_status, 
                content_recipients.id as recipient_id,
                users.name as sender_name
            FROM content_recipients 
            JOIN contents ON content_recipients.content_id = contents.id 
            JOIN users ON content_recipients.sender_id = users.id
            WHERE content_recipients.user_id = :user_id
            ORDER BY contents.created_at DESC";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all notifications
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log the error message and display a generic error message
        error_log("Database query failed: " . $e->getMessage(), 0);
        echo '<p class="text-muted mb-2 font-13"><strong>Error :</strong> <span class="ml-2">Unable to retrieve notifications.</span></p>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #9dd53a, #3c8722);
            font-family: Arial, sans-serif;
        }

        .card {
            margin-top: 50px;
        }

        .card-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 1200px;
        }

        .action-btn {
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .unread-btn {
            background-color: red;
        }

        .read-btn {
            background-color: green;
        }
    </style>
</head>

<body>
    <!-- Navbar Section -->
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-light" style="position: sticky; top: 0; z-index: 10; background-image: linear-gradient(to right, #9dd53a, #3c8722); padding: 0 !important;">
            <a class="navbar-brand" href="home.php"><img src="images/logo.png" alt="Logo" style="height: 40px; padding-left: 20px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="outline: none !important;">
                <i class="fa fa-bars" style="color: #fff; font-size: 30px !important;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="home.php" style="color: #fff !important; font-weight: 600;">HOME</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="profile.php" style="color: #fff !important; font-weight: 600;">PROFILE</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="user_notifications.php" style="color: #fff !important; font-weight: 600;">EMPLOYEE NOTIFICATIONS</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="user_share_content.php" style="color: #fff !important; font-weight: 600;">SHARE CONTENT</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="user_tvprograms.php" style="color: #fff !important; font-weight: 600;">TV PROGRAMS</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="user_courses.php" style="color: #fff !important; font-weight: 600;">TRAINEE COURSES</a>
                    </li>

                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </nav>
    </section>

    <?php if (!$not_logged_in): ?>
        <div class="container mt-4">
            <div class="card-box">
                <h3>USER NOTIFICATIONS</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Notification</th>
                            <th>Sender</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notifications as $notification): ?>
                            <tr>
                                <td>
                                    <?php
                                    // Display truncated content directly
                                    echo (strlen($notification['content']) > 100) ? substr($notification['content'], 0, 100) . '...' : $notification['content'];
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($notification['sender_name']); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($notification['created_at'])); ?></td>
                                <td><?php echo date('H:i:s', strtotime($notification['created_at'])); ?></td>
                                <td>
                                    <!-- Read More Button -->
                                    <!-- Read More Icon (Only Icon, No Background) -->
                                    <button class="read-more-btn" style="background: none; border: none; cursor: pointer;" data-content="<?php echo htmlspecialchars($notification['content']); ?>">
                                        <i class="fas fa-eye fa-sm" style="color: #333;"></i> <!-- Dark color for the icon -->
                                    </button>

                                    <!-- Mark as Read/Unread Button -->
                                    <button class="action-btn <?php echo $notification['read_status'] == 1 ? 'read-btn' : 'unread-btn'; ?>" data-id="<?php echo $notification['recipient_id']; ?>">
                                        <?php if ($notification['read_status'] == 1): ?>
                                            <i class="fas fa-check"></i> <!-- Check icon for 'Read' -->
                                        <?php else: ?>
                                            <i class="fas fa-envelope"></i> <!-- Envelope icon for 'Mark as Read' -->
                                        <?php endif; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentModalLabel">Notification Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalContent"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach click event listener to all 'Read More' buttons
            document.querySelectorAll('.read-more-btn').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    // Get full content from data attribute
                    var fullContent = this.getAttribute('data-content');
                    // Set content in the modal
                    document.getElementById('modalContent').innerHTML = fullContent;
                    // Show the modal
                    var contentModal = new bootstrap.Modal(document.getElementById('contentModal'));
                    contentModal.show();
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>