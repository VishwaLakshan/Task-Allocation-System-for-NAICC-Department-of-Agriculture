<?php
// Database connection
include('config_db.php');

$tasks = []; // Initialize the tasks variable

try {
    // Query to select all tasks along with user email, name, and division from the users table
    $sql_tasks = "SELECT t.task_id, t.task, t.progress, t.id AS id, u.email, u.name AS user_name, u.division
                  FROM tasks t 
                  JOIN users u ON t.id = u.id"; // Join tasks with users based on id

    // Prepare and execute the statement
    $stmt_tasks = $conn->prepare($sql_tasks);
    $stmt_tasks->execute();

    // Fetch all tasks
    $tasks = $stmt_tasks->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Closing the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <style>
        /* Basic styling for the task list */
        body {
            background-color: lightgray;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .user-section {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .task-item {
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        h3 {
            margin: 0;
            color: #2a6496;
        }

        p {
            margin: 5px 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2a6496;
        }

        .progress-container {
            width: 100%;
            background: #f3f3f3;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 20px; /* Height of the progress bar */
            background: #4caf50; /* Green color */
            text-align: center; /* Center text inside the progress bar */
            line-height: 20px; /* Center the text vertically */
            color: white; /* Text color */
            transition: width 0.5s; /* Animation for width change */
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

    </style>
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#"><img src="images/logo.png" alt="Logo" style="height: 40px;"></a>
        <div class="navbar-links">
            <a href="#top">HOME</a>
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
        <h1>Tasks List</h1>
        <?php if (count($tasks) > 0): ?>
            <?php 
                // Group tasks by user
                $grouped_tasks = [];
                foreach ($tasks as $task) {
                    $Id = $task['id'];
                    if (!isset($grouped_tasks[$Id])) {
                        $grouped_tasks[$Id] = [
                            'email' => $task['email'],
                            'user_name' => $task['user_name'], // User name from users table
                            'division' => $task['division'], // Division from users table
                            'tasks' => []
                        ];
                    }
                    $grouped_tasks[$Id]['tasks'][] = [
                        'task' => $task['task'],
                        'progress' => $task['progress']
                    ];
                }
            ?>
            <?php foreach ($grouped_tasks as $Id => $userData): ?>
                <div class="user-section">
                    <h3>User Name: <?php echo htmlspecialchars($userData['user_name']); ?> (Email: <?php echo htmlspecialchars($userData['email']); ?>)</h3>
                    <p>Division: <?php echo htmlspecialchars($userData['division']); ?></p>
                    <?php if (count($userData['tasks']) > 0): ?>
                        <?php foreach ($userData['tasks'] as $task): ?>
                            <div class="task-item">
                                <p>Task: <?php echo htmlspecialchars($task['task']); ?></p>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: <?php echo htmlspecialchars($task['progress']); ?>%;">
                                        <?php echo htmlspecialchars($task['progress']); ?>%
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tasks found for this user.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tasks found.</p>
        <?php endif; ?>
    </div>

    <script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    // Get the search term
    let searchTerm = this.value.toLowerCase();

    // Get all user sections
    let userSections = document.querySelectorAll('.user-section');

    // Loop through all user sections
    userSections.forEach(function(section) {
        let userName = section.querySelector('h3').textContent.toLowerCase();
        let email = section.querySelector('h3').textContent.toLowerCase();
        let division = section.querySelector('p').textContent.toLowerCase(); // Search by division
        let taskItems = section.querySelectorAll('.task-item');
        let hasVisibleTask = false;

        // Loop through all task items in the current user section
        taskItems.forEach(function(task) {
            let taskName = task.querySelector('p').textContent.toLowerCase(); // Get task name from the first p

            // If the user name, email, task name, or division contains the search term, show the task
            if (userName.includes(searchTerm) || email.includes(searchTerm) || taskName.includes(searchTerm) || division.includes(searchTerm)) {
                task.style.display = 'block'; // Show matching task
                hasVisibleTask = true; // Mark that we have at least one visible task
            } else {
                task.style.display = 'none'; // Hide non-matching task
            }
        });

        // Show or hide user section based on task visibility
        section.style.display = hasVisibleTask ? 'block' : 'none';
    });
});
</script>


</body>
</html>
