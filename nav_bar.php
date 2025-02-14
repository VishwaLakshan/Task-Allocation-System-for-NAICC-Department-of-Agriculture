<?php

// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']);
$is_admin = false;

// Check if the logged-in user is admin
if ($is_logged_in) {
    include('config_db.php'); // Include database connection
    $id = $_SESSION['id'];

    // Fetch user data
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $email = $user['email'];

        // Check if the user is an admin
        if ($email == 'admin@ad.gov') {
            $is_admin = true;
        }
    }
}
?>

<!-- Navbar Section -->
<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light" style="position: sticky; top: 0; z-index: 10; margin-top: 20px; background-image: linear-gradient(to right, #9dd53a, #3c8722); padding: 0 !important; margin-bottom: 160px;">
        <a class="navbar-brand" href="home.php"><img src="images/logo.png" alt="Logo" style="height: 40px; padding-left: 20px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="outline: none !important;">
            <i class="fa fa-bars" style="color: #fff; font-size: 30px !important;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item" style="padding: 0 10px;">
                    <a class="nav-link" href="home.php" style="color: #fff !important; font-weight: 600;">HOME</a>
                </li>
                <!-- Only show PROFILE, LOGOUT if the user is logged in -->
                <?php if ($is_logged_in): ?>
                <li class="nav-item" style="padding: 0 10px;">
                    <a class="nav-link" href="profile.php" style="color: #fff !important; font-weight: 600;">PROFILE</a>
                </li>

                <!-- Show ADMIN DASHBOARD if the user is an admin -->
                <?php if ($is_admin): ?>
                <li class="nav-item" style="padding: 0 10px;">
                    <a class="nav-link" href="admin_dashboard.php" style="color: #fff !important; font-weight: 600;">ADMIN DASHBOARD</a>
                </li>
                <?php else: ?>
                <!-- Otherwise, show EMPLOYEE -->
                <li class="nav-item" style="padding: 0 10px;">
                    <a class="nav-link" href="user_notifications.php" style="color: #fff !important; font-weight: 600;">EMPLOYEE NOTIFICATIONS</a>
                </li>                
                <?php endif; ?>

                <li class="nav-item" style="padding: 0 10px;">
                    <a class="nav-link" href="logout.php" style="color: #fff !important; font-weight: 600;">LOGOUT</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</section>
