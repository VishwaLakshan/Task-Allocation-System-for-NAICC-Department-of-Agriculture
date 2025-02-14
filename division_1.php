<?php
// Database connection
include('config_db.php');

// Query to get users in Agriculture Advisory Services
$sql_users = "SELECT id, name, position, email, division FROM users WHERE division = 'Agriculture Advisory Services'";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Advisory Services Employees</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        <?php include('common_styles.css'); ?> /* Assuming you include this as a separate file */

        /* General Styles */
        body {
            background: lightgreen;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navigation Bar Styles */
        .navbar {
            background-image: linear-gradient(to right, #9dd53a, #3c8722);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            font-weight: 600;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .search-bar {
            padding: 10px 10px;
        }

        .search-bar input[type="text"] {
            padding: 8px;
            font-size: 11px;
        }

        /* Container Styles */
        .container {
            display: flex;
            flex-direction: column; /* Start with a column layout for mobile */
            padding: 20px;
        }

        h1 {
            text-align: center; /* Center the title */
        }

        /* Card Container Styles */
        .card-container {
            display: flex;
            flex-wrap: wrap; /* Ensures the cards wrap to the next row when necessary */
            justify-content: space-between; /* Creates equal space between the cards */
            margin-top: 20px;
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 22%; /* Adjusted for more cards per row */
            margin: 10px;
            padding: 10px;
            text-align: center;
            transition: 0.3s;
            position: relative;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Profile Picture Styling */
        .profile-pic {
            background-color: #f2f2f2;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 0 auto 16px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-pic img {
            width: 80%;
            border-radius: 50%;
        }

        /* User Info Styling */
        .user-info h3 {
            margin: 0;
            font-size: 22px;
        }

        .user-info p {
            color: #777;
            font-size: 14px;
            margin: 5px 0;
        }

        /* Checkbox Styling */
        .select-card {
            position: absolute;
            top: 10px;
            right: 10px;
            transform: scale(1.2);
        }

        button {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #3c8722;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2a5f1a;
        }

        /* Responsive styles for small screens */
        @media (max-width: 768px) {
            .card {
                width: 100%; /* Full width on smaller screens */
            }
        }
    </style>
</head>
<body>


<!-- Navigation Bar -->
<nav class="navbar">
    <a class="navbar-brand" href="#"><img src="images/logo.png" alt="Logo" style="height: 40px;"></a>
    <div class="navbar-links">
        <a href="home.php">HOME</a>
        <a href="signin.php">SIGNIN</a>
        <a href="admin_dashboard.php">ADMIN DASHBOARD</a>
        <a href="logout.php">LOGOUT</a>
    </div>
    <!-- Search bar within Navbar -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search">
    </div>
</nav>

<div class="container">
    <h1>Employee Profiles</h1>
    <form id="selectForm" method="POST" action="process_selection.php">
        <div class="card-container">
            <?php
            if ($stmt_users->rowCount() > 0) {
                while ($user = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <div class='card'>
                        <input type='checkbox' class='select-card' name='selected_users[]' value='{$user['id']}'>
                        <div class='profile-pic'>
                            <img src='path_to_profile_image/{$user['id']}.jpg' alt='Profile Picture'>
                        </div>
                        <div class='user-info'>
                            <h3>" . htmlspecialchars($user['name']) . "</h3>
                            <p>Position: " . htmlspecialchars($user['position']) . "</p>
                            <p>Email: " . htmlspecialchars($user['email']) . "</p>
                            <p>Division: " . htmlspecialchars($user['division']) . "</p>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No employees found in Agriculture Advisory Services.</p>";
            }
            ?>
        </div>
        <button type="submit">Submit Selection</button>
    </form>
</div>

<!-- JavaScript for filtering profiles -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchTerm = this.value.toLowerCase();
        let profileCards = document.querySelectorAll('.card');

        profileCards.forEach(function(card) {
            let name = card.querySelector('h3').textContent.toLowerCase();
            let position = card.querySelector('p:nth-child(2)').textContent.toLowerCase();
            let division = card.querySelector('p:nth-child(4)').textContent.toLowerCase();

            if (name.includes(searchTerm) || position.includes(searchTerm) || division.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
