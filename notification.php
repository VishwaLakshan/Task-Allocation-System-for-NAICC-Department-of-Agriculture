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
    <title>Notifications</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navigation.css">
    <!-- Only include one Bootstrap version -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card {
            margin-top: 50px;
        }

        .card-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 800px;
        }

        /* Modern table styles */
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table tr:hover {
            background-color: #f1f1f1;
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
    <!-- Include Navigation Bar -->
    <?php include 'nav_bar.php'; ?>

    <!-- Include Sidebar Navigation -->
    <?php include 'sidebar_nav.php'; ?>

    <div class="pcoded-main-container">
        <div class="pcoded-wrapper container">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h2>NOTIFICATIONS</h2>
                                    </div>
                                    <?php if (!$not_logged_in): ?>
                                        <div class="table-responsive">
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
                                                                echo (strlen($notification['content']) > 100) ? substr($notification['content'], 0, 100) . '...' : $notification['content'];
                                                                ?>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($notification['sender_name']); ?></td>
                                                            <td><?php echo date('Y-m-d', strtotime($notification['created_at'])); ?></td>
                                                            <td><?php echo date('H:i:s', strtotime($notification['created_at'])); ?></td>
                                                            <td>
                                                                <button class="read-more-btn" style="background: none; border: none; cursor: pointer;" data-content="<?php echo htmlspecialchars($notification['content']); ?>">
                                                                    <i class="fas fa-eye fa-sm" style="color: #333;"></i>
                                                                </button>
                                                                <button class="action-btn <?php echo $notification['read_status'] == 1 ? 'read-btn' : 'unread-btn'; ?>" data-id="<?php echo $notification['recipient_id']; ?>">
                                                                    <?php if ($notification['read_status'] == 1): ?>
                                                                        <i class="fas fa-check"></i>
                                                                    <?php else: ?>
                                                                        <i class="fas fa-envelope"></i>
                                                                    <?php endif; ?>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Only include one version of Bootstrap's JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var contentModalElement = document.getElementById('contentModal');
            var contentModal = new bootstrap.Modal(contentModalElement);

            document.querySelectorAll('.read-more-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var fullContent = this.getAttribute('data-content');
                    document.getElementById('modalContent').innerHTML = fullContent;
                    contentModal.show();
                });
            });

            contentModalElement.addEventListener('hidden.bs.modal', function() {
                document.getElementById('modalContent').innerHTML = '';
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/vendor-all.min.js"></script>
    <script src="js/ripple.js"></script>
    <script src="js/pcoded.min.js"></script>
</body>

</html>