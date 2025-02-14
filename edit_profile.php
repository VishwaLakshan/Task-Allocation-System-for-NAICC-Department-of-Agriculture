<?php
session_start(); // Start the session

// Include the database connection file
include('config_db.php'); // Ensure this file has PDO setup

// Check if the user ID is set in the session
if (!isset($_SESSION['id'])) {
    die("User not logged in.");
}

$id = $_SESSION['id']; // Get the user ID from the session

// Initialize user data variable
$user = null;

try {
    // Prepare and execute the query to fetch user data
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
    } else {
        die("User not found.");
    }
} catch (PDOException $e) {
    // Log the error and display a generic error message
    error_log("Database query failed: " . $e->getMessage(), 0);
    die("Unable to retrieve user data.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #9dd53a, #3c8722);
            font-family: Arial, sans-serif;
        }

        .card-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 500px;
        }

        .btn-primary {
            margin-top: 20px;
        }

        /* Custom green button */
        .btn-custom {
            background-color: #28a745;
            /* Green color */
            border-color: #28a745;
            /* Green border color */
            color: #fff;
            /* White text color */
        }

        .btn-custom:hover {
            background-color: #218838;
            /* Darker green on hover */
            border-color: #1e7e34;
            /* Darker green border on hover */
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card-box">
                    <h4>Edit Profile</h4>
                    <form action="update_profile.php" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="profilePic" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profilePic" name="profilePic">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($user['position'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="division" class="form-label">Division</label>
                            <input type="text" class="form-control" id="division" name="division" value="<?php echo htmlspecialchars($user['division'] ?? ''); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-custom">Update Profile</button>

                        <a href="profile.php" style="color: #28a745; text-decoration: none;">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>