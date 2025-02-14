<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
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
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            max-width: 600px;
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
            border: none; /* Remove border */
            box-shadow: none; /* Remove box shadow if any */
            outline: none; 
           
            
        }
        .add-task-button {
            background-color: #5cb85c;
        }
        .add-task-button:hover {
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
    <h2>Add New Task</h2>
    <div class="card">
        <form action="add_task_action.php" method="POST">
            <div class="form-group">
                <label for="taskName">Task Name</label>
                <input type="text" class="form-control" id="taskName" name="taskName" required>
            </div>
            <div class="form-group">
                <label for="dueDate">Due Date</label>
                <input type="date" class="form-control" id="dueDate" name="dueDate" required>
            </div>
            <div class="form-group">
                <label for="progress">Progress (%)</label>
                <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Not Started">Not Started</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <div class="text-center"> <!-- Center buttons horizontally -->
                <button type="submit" class="add-task-button"><i class="fas fa-plus"></i> Add Task</button>
                <button type="button" class="cancel-button" onclick="window.location.href='profile.php';"><i class="fas fa-times"></i> Cancel</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
