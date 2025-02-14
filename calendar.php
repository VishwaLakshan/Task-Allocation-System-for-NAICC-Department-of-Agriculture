
<?php
// Include necessary files
include_once "config_db.php"; // Include the PDO connection
include_once "Events.php";

// Create object from Events class and pass PDO connection
$eventsObj = new Events($conn);

// Fetch event data for FullCalendar
$events = json_encode($eventsObj->displayData()); // Properly encode events as JSON

// Fetch event data for the HTML table
$event_table = $eventsObj->displayDataForTable();

// Handle form submission for creating new events
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title'], $_POST['description'], $_POST['start_date'], $_POST['end_date'])) {
        $eventsObj->storeData($_POST);
        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid form data']);
        exit();
    }
}

// Handle DELETE request for deleting an event
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the input from the request body
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['id'])) {
        $deleted = $eventsObj->deleteEvent($input['id']);
        
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete event']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    }
    
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script src="https://kit.fontawesome.com/f2ab1a3f38.js" crossorigin="anonymous"></script>
    
    <style>
        /* Reducing the size of the calendar */
        #calendar {
            width: 100%; /* Adjust width as needed */
            height: 450px; /* Set calendar height */
            margin-bottom: 20px;
        }

        /* Reducing card sizes */
        .card {
            max-width: 90%; /* Adjust to control card width */
            margin: 10px auto; /* Centering and spacing */
        }

        /* Reducing padding for a more compact look */
        .card-body {
            padding: 10px;
        }

        /* Smaller form controls for compact form */
        .form-control, .btn {
            font-size: 0.9rem;
            padding: 5px;
        }

        /* Adjusting the table layout to be more compact */
        table.table td, table.table th {
            padding: 8px;
            font-size: 0.9rem;
        }

        .btn-custom {
            background-color: #28a745;
            color: #fff;
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
    </style>
</head>
<body>

<section id="nav-bar"> 
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid"> <!-- This class will help align items within the navbar -->
            <a class="navbar-brand" href="#"><img src="images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"> <!-- Use ms-auto instead of ml-auto for Bootstrap 5 -->
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">PROFILE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_task.php">MY TASK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>


<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div id='calendar'></div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form id="event-form">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <input type="text" class="form-control" name="description" required>
                        </div>
                        <div class="form-group">
                            <label>Start Date:</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label>End Date:</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-custom" style="float:right;" value="Create">
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (is_array($event_table)) {
                                foreach ($event_table as $data) {
                                    $startDate = date('Y-m-d', strtotime($data['start']));
                                    $endDate = date('Y-m-d', strtotime($data['end']));
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($data['title']) . "</td>";
                                    echo "<td>" . htmlspecialchars($data['description']) . "</td>";
                                    echo "<td>" . $startDate . "</td>";
                                    echo "<td>" . $endDate . "</td>";
                                    echo "<td><button class='btn btn-danger btn-sm' onclick='deleteEvent(" . $data['event_id'] . ")'><i class='fas fa-trash'></i></button></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?php echo $events; ?>, // Load events from the PHP variable
            allDay: false,
            displayEventTime: false,
        });
        calendar.render();

        // Handle form submission using AJAX
        document.getElementById('event-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission
            var formData = new FormData(this);
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to update the event list
                } else {
                    alert('Failed to create event');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Function to delete an event
    function deleteEvent(id) {
        if (confirm('Are you sure you want to delete this event?')) {
            fetch('', {
                method: 'DELETE',
                body: JSON.stringify({ id: id }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to update the event list
                } else {
                    alert('Failed to delete event: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>

</body>
</html>
