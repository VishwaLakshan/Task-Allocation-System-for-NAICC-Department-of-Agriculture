<?php
include("header.inc");
include('config_db.php'); 

try {
    $query = "SELECT * FROM main_task";
    $tasks = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching tasks: " . $e->getMessage();
    exit();
}
?>

<div class="content">
    <h2 class="heading">Task Dashboard</h2>

    <div class="task-section" data-aos="fade-up" data-aos-duration="800">
        <h3 class="section-title">All Tasks</h3>
        <div class="task-cards">
            <?php foreach ($tasks as $task): ?>
                <a href="view_task.php?main_task_id=<?= htmlspecialchars($task['main_task_id']); ?>" target="_blank" class="task-card">
                    
                    <p>Main Task Name: <?= isset($task['main_task_name']) ? htmlspecialchars($task['main_task_name']) : 'N/A'; ?></p>
                    <p>Due Date: <?= isset($task['due_date']) ? htmlspecialchars($task['due_date']) : 'N/A'; ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    .content {
        padding: 20px;
    }
    .task-section {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }
    .task-cards {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .task-card {
        display: block;
        background-color: #f5f5f5;
        padding: 15px;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, transform 0.3s;
    }
    .task-card:hover {
        background-color: #e0f7fa;
        transform: translateY(-3px);
    }
    .task-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    p {
        margin: 0;
        font-size: 14px;
        color: #555;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .task-section {
            width: 100%;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init();
    });
</script>
