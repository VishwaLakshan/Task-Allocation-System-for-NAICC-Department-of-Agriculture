<?php
session_start();
include('config_db.php'); // This file contains the PDO connection setup

// Flag for login status
$not_logged_in = false;

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    $not_logged_in = true;
    // You can optionally use header to redirect to another page if desired
    // header('Location: login.php');
    // exit();
}

// Fetch user data from the database
$id = $_SESSION['id'] ?? null;

if (!$not_logged_in) {
    try {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo '<p class="text-muted mb-2 font-13"><strong>Error :</strong> <span class="ml-2">User not found.</span></p>';
            exit();
        }
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage(), 0);
        echo '<p class="text-muted mb-2 font-13"><strong>Error :</strong> <span class="ml-2">Unable to retrieve user data.</span></p>';
        exit();
    }

    // Define allowed email domain
    $allowed_domain = 'ad.gov';

    // Validate email domain
    $email_domain = substr(strrchr($user['email'], "@"), 1);

    // Check for admin user
    if ($user['email'] === 'admin@ad.gov') {
        header('Location: admin_dashboard.php');
        exit();
    }

    // Restrict access to users outside the allowed domain
    if ($email_domain != $allowed_domain) {
        echo '<p class="text-muted mb-2 font-13"><strong>Access Denied:</strong> <span class="ml-2">Profile creation is restricted.</span></p>';
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 500px;
            display: flex;
            align-items: flex-start;
        }
        .avatar-xl {
            width: 120px;
            height: 120px;
            margin-right: 20px;
        }
        .profile-details {
            flex-grow: 1;
        }
        .btn-custom {
            background-color: #28a745;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #218838;
        }

        #nav-bar
{
    position: sticky;
    top: 0;
    z-index: 10;
}
.navbar
{
    background-image: linear-gradient(to right, #9dd53a, #3c8722);
    padding: 0 !important;
}
.navbar-brand img
{
height:40px;
padding-left:20px;
}
.navbar-nav li
{
    padding: 0 10px;
}
.navbar-nav li a
{
    color: #fff !important;
    font-weight: 600;
    float: right;
    text-align: left;
}
.fa-bars
{
    color: #fff;
    font-size: 30px !important;
}
.navbar-toggler
{
    outline:none !important;
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
                        <a class="nav-link" href="my_tasks.php" style="color: #fff !important; font-weight: 600;">MY TASK</a>
                    </li>
                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="calendar.php" style="color: #fff !important; font-weight: 600;">MY CALENDAR</a>
                    </li>

                    <li class="nav-item" style="padding: 0 10px;">
                        <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                    </li>
                  
                </ul>
            </div>
        </nav>
    </section>



    <!-- Popup Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                You need to be logged in to access this page.
            </div>
            <div class="modal-footer">
                <a href="signin.php" class="btn btn-custom">Login</a>
                <a href="home.php" class="btn btn-custom">Close</a>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Show the login modal if the user is not logged in
    <?php if ($not_logged_in): ?>
        document.addEventListener('DOMContentLoaded', function() {
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {});
            loginModal.show();
        });
    <?php endif; ?>
</script>







    

<?php if (!$not_logged_in): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card-box">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                <div class="profile-details">
                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo htmlspecialchars($user['name']); ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Position :</strong> <span class="ml-2"><?php echo htmlspecialchars($user['position']); ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo htmlspecialchars($user['email']); ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Phone :</strong><span class="ml-2"><?php echo htmlspecialchars($user['phone']); ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Location :</strong> <span class="ml-2"><?php echo htmlspecialchars($user['location']); ?></span></p>
                    <p class="text-muted mb-1 font-13"><strong>Division :</strong> <span class="ml-2"><?php echo htmlspecialchars($user['division']); ?></span></p>
                    <div class="btn">
                        <?php if (!$not_logged_in && $email_domain === $allowed_domain): ?>
                            <a href="edit_profile.php" class="btn btn-custom">Edit Profile</a>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Edit Profile (Access Denied)</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Task Progress Section -->
           <!-- Task Progress Section -->
<div class="container mt-5">
    <h3>Employee Task Progress</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Due Date</th>
                <th>Progress</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="taskTable">
            <?php
            // Fetch tasks from the database using PDO
            try {
                $query = "SELECT * FROM tasks WHERE id = :id"; // Assuming `user_id` is the foreign key in the tasks table
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the logged-in user's ID
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $counter = 1;
                    while ($task = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr id='task-{$task['id']}'>
                                <td>{$counter}</td>
                                <td>{$task['task']}</td>
                                <td>{$task['due_date']}</td>
                                <td>
                                    <div class='progress'>
                                        <div class='progress-bar' style='width:{$task['progress']}%'>{$task['progress']}%</div>
                                    </div>
                                </td>
                                 <div class='status'>
                                <td><span class='status" . ($task['status'] == 'In Progress' ? 'success' : ($task['status'] == 'Completed' ? 'success' : ($task['status'] == 'Not Started' ? 'info' : 'primary'))) . "'>{$task['status']}</span></td>
                                </div>
                                <td>
                                    <a href='edit_task.php?task_id={$task['task_id']}' class='btn btn-custom btn-sm'>Edit</a>
                                    <button class='btn btn-danger btn-sm' onclick='deleteTask({$task['task_id']})'>Delete</button>
                                </td>
                              </tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No tasks found.</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='6'>Error fetching tasks.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="add_task.php" class="btn btn-success">Add New Task</a>
</div>

        </div>
    </div>
</div>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function deleteTask(task_id) {
        if (confirm("Are you sure you want to delete this task?")) {
            $.post('delete_task.php', { task_id: task_id }, function (response) {
                if (response.success) {
                    $('#task-' + task_id).remove();
                    alert(response.message);
                } else {
                    alert("Error deleting task.");
                }
            }, 'json');
        }
    }
</script>

</body>
</html>
