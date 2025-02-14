<?php
include('config_db.php'); 

// Create the subtasks table if it doesn't exist (without task_number)
$createTableQuery = "
CREATE TABLE IF NOT EXISTS subtasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    main_task_id INT(11) NOT NULL,
    subtask_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    due_date DATE NOT NULL,
    priority ENUM('Low', 'Medium', 'High') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (main_task_id) REFERENCES main_task(id) ON DELETE CASCADE
)";

$conn->exec($createTableQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $main_task_name = $_POST['main_task_name'];
    $subtask_name = $_POST['subtask_name'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    // Retrieve the main task ID from the main_task table
    $stmt = $conn->prepare("SELECT main_task_id FROM main_task WHERE main_task_name = :main_task_name LIMIT 1");
    $stmt->execute([':main_task_name' => $main_task_name]);  // Use the correct parameter
    $main_task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($main_task) {
        $main_task_id = $main_task['main_task_id']; // Get the correct main task ID

        // Insert the subtask
        $insertSubtaskQuery = "
        INSERT INTO subtasks (main_task_id, subtask_name, description, due_date, priority)
        VALUES (:main_task_id, :subtask_name, :description, :due_date, :priority)";
        
        $stmt = $conn->prepare($insertSubtaskQuery);
        
        // Execute the insertion
        $stmt->execute([
            ':main_task_id' => $main_task_id,
            ':subtask_name' => $subtask_name,
            ':description' => $description,
            ':due_date' => $due_date,
            ':priority' => $priority,
        ]);

        header('Location: add_subtask.php?success=1');
        exit();
    } else {
        echo "Main task not found.";
    }
}
?>
