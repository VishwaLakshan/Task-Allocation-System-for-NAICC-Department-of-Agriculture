<?php
session_start();
include 'config_db.php'; // Include your database connection

// Check if task_id is provided in the URL
if (isset($_GET['task_id'])) {
    $task_id = intval(trim($_GET['task_id'])); // Convert to integer

    // Prepare the SQL statement to select the task by task_id
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE task_id = :task_id");
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the task data
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if task exists
    if (!$task) {
        echo "<div class='alert alert-danger'>Task not found or doesn't exist!</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>No task ID provided!</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Light background color */
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            max-width: 600px; /* Set consistent max width */
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            width: 48%; /* Width of the buttons */
            margin: 1%; /* Margin between buttons */
        }
        .alert {
            color: #d9534f;
            text-align: center;
        }
        button {
            color: white;
            margin-top: 10px;
            border: none; /* Remove border */
            box-shadow: none; /* Remove box shadow if any */
            outline: none; 
           
            
        }
        .update-button {
            background-color: #5cb85c;
        }
        .update-button:hover {
            background-color: #4cae4c;
        }
        .cancel-button {
            background-color: #d9534f;
        }
        .cancel-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        <div class="card">
            <form action="edit_task_action.php" method="POST">
                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['task_id']); ?>">
                
                <label for="taskName">Task Name:</label>
                <input type="text" name="taskName" id="taskName" class="form-control" value="<?php echo htmlspecialchars($task['task']); ?>" required>
                
                <label for="dueDate">Due Date:</label>
                <input type="date" name="dueDate" id="dueDate" class="form-control" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
                
                <label for="progress">Progress (%):</label>
                <input type="number" name="progress" id="progress" class="form-control" value="<?php echo htmlspecialchars($task['progress']); ?>" min="0" max="100" required>
                
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Not Started" <?php echo ($task['status'] == 'Not Started') ? 'selected' : ''; ?>>Not Started</option>
                    <option value="In Progress" <?php echo ($task['status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                    <option value="Completed" <?php echo ($task['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                </select>
                
                <div class="text-center"> <!-- Center buttons horizontally -->
                    <button type="submit" class="update-button"><i class="fas fa-save"></i> Update Task</button>
                    <button type="button" class="cancel-button" onclick="window.history.back();"><i class="fas fa-times"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
