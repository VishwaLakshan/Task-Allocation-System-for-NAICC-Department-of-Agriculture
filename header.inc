<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar Navigation with Gradient</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/add_subtask.css" rel="stylesheet">
    <link href="css/nav.css" rel="stylesheet">
    <link href="css/add_task.css" rel="stylesheet">
    <link href="css/calendar.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/view.css" rel="stylesheet">
    <link href="css/view_task.css" rel="stylesheet">

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>

<div class="main-container">
    <div class="sidebar sidebar-shadow">
        <nav class="navbar navbar-expand-lg navbar-dark flex-column">

            <ul class="navbar-nav flex-column w-100">
             <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><span>Notification</span></a>
                </li>
  <li class="nav-item">
                    <a class="nav-link" href="register_employee.php"><span>Add Employee</span></a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="calendar.php"><span>Calendar</span></a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="add_divisions.php"><span>Add Divisions</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_main_task.php"><span>Add Main Task</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_subtask.php"><span>Add Sub Task</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><span>Progress</span></a>
                </li>
            </ul>

            <a href="#" class="btn btn-danger logout-button">Logout</a> <!-- Logout button -->
        </nav>
    </div>