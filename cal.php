<?php
include "db_conn.php";
session_start();
include "navbar.php";
$user_id = $_SESSION['user_id'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to delete past reminders but keep those for today and future dates
function deletePastReminders($conn) {
    $today = date('Y-m-d');
    $stmt = $conn->prepare("DELETE FROM reminders WHERE date < ? AND date != ?");
    $stmt->bind_param("ss", $today, $today);
    $stmt->execute();
    $stmt->close();
}

// Call function to delete past reminders
deletePastReminders($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $reminder = $_POST['reminder'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO reminders (date, reminder, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $date, $reminder, $user_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>New reminder added successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}


// Fetch reminders for the logged-in user
$sql = "SELECT * FROM reminders WHERE user_id = ? ORDER BY date";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

$reminders = [];
$hasReminderToday = false;
while ($row = $result->fetch_assoc()) {
    $reminders[$row['date']][] = $row['reminder'];
    // Check if there is a reminder for the current day
    if ($row['date'] === date('Y-m-d')) {
        $hasReminderToday = true;
    }
}

$stmt->close();
$conn->close();

// Define current month and year from query parameters or default to current date
$currentMonth = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$currentYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Handle month and year change
if (isset($_GET['change'])) {
    if ($_GET['change'] === 'next') {
        if ($currentMonth == 12) {
            $currentMonth = 1;
            $currentYear++;
        } else {
            $currentMonth++;
        }
    } elseif ($_GET['change'] === 'prev') {
        if ($currentMonth == 1) {
            $currentMonth = 12;
            $currentYear--;
        } else {
            $currentMonth--;
        }
    }
}

// Determine the current day for highlighting
$currentDay = date('Y-m-d');
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Reminders</title>
  <style>
   .calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background-color: #333;
   }
   .calendar-day {
    border: 1px solid #555;
    padding: 15px;
    text-align: center;
    position: relative;
    background-color: #444;
    color: #ddd;
    transition: background-color 0.3s;
   }
   .calendar-day:hover {
    background-color: #555;
   }
   .calendar-day.current-day {
    background-color: #007bff; /* Highlight current day in blue */
    color: #fff;
   }
   .calendar-header {
    background-color: #222;
    color: #fff;
    font-weight: bold;
    padding: 10px;
   }
   .reminder-list {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #444;
    border: 1px solid #555;
    z-index: 10;
    display: none;
    max-height: 150px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
   }
   .calendar-day:hover .reminder-list {
    display: block;
   }
   .reminder-item {
    padding: 10px;
    border-bottom: 1px solid #555;
    color: #eee;
   }
   .reminder-item:last-child {
    border-bottom: none;
   }
   .reminder-item:hover {
    background-color: #555;
    cursor: pointer;
   }
   .form-container {
    background-color: #222;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    color: #ddd;
    display: none; /* Initially hide the form */
   }
   body {
    background: url('./assets/images/cloud.jpg') no-repeat center center fixed;
    background-size: cover;
    background-color: rgba(0, 0, 0, 0.3);
   }
   .reminder-day {
    background-color: #f94ca4;
    border: 1px solid #f94ca4;
   }
   .badge-circle {
    border-radius: 50%;
    padding: 0.5em 0.7em;
    font-size: 0.75em;
    height: 1.5em;
    width: 1.5em;
    display: inline-flex;
    justify-content: center;
    align-items: center;
   }
   .badge-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        margin-left: 5px; /* Space between text and dot */
    }
   @media (max-width: 991px) {
    .sidebar {
        background-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
    }
   }
   .current-day {
    background-color: #007bff; /* Highlight current day in blue */
    color: #fff;
    border: 2px solid #0056b3; /* Optional: Highlight border for current day */
}

  </style>
</head>
<body>

   </br></br>


    <div class="container mt-5">
        <h1 class="mb-4" style="color: white">Reminders</h1>

        <!-- Calendar Navigation -->
        <div class="d-flex justify-content-between mb-4">
            <a href="?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>&change=prev" class="btn btn-secondary">&laquo; Previous</a>
            <?php
            $monthName = date('F', strtotime("$currentYear-$currentMonth-01"));
            echo "<h2 class='mb-4'>$monthName $currentYear</h2>";
            ?>
            <a href="?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>&change=next" class="btn btn-secondary">Next &raquo;</a>
        </div>

        <!-- Calendar -->
        <div class="calendar mb-4">
            <?php
            $headers = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($headers as $header) {
                echo "<div class='calendar-header'>$header</div>";
            }

            $daysInMonth = date('t', strtotime("$currentYear-$currentMonth-01"));
            $firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonth-01"));

            for ($i = 1; $i < $firstDayOfMonth; $i++) {
                echo "<div class='calendar-day'></div>";
            }

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                $hasReminder = isset($reminders[$date]) ? "reminder-day" : "";
                $dayReminders = isset($reminders[$date]) ? implode('', array_map(function($reminder) {
                    return "<div class='reminder-item'>$reminder</div>";
                }, $reminders[$date])) : '';

                $currentClass = ($date === $currentDay) ? "current-day" : ""; // Highlight current day

                echo "<div class='calendar-day $hasReminder $currentClass' data-date='$date' onclick='showForm(\"$date\")'>";
                echo "<strong>$day</strong>";
                if ($dayReminders) {
                    echo "<div class='reminder-list'>$dayReminders</div>";
                }
                echo "</div>";
            }
            ?>
        </div>

        <!-- Add Reminder Form -->
        <div class="form-container" id="reminder-form">
            <h2>Add Reminder</h2>
            <form method="POST" action="">
                <input type="hidden" id="reminder-date" name="date">
                <div class="mb-3">
                    <label for="reminder" class="form-label">Reminder</label>
                    <textarea id="reminder" name="reminder" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Reminder</button>
                <button type="button" class="btn btn-secondary mt-2" onclick="hideForm()">Cancel</button>
            </form>
        </div>
    </div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    function showForm(date) {
        document.getElementById('reminder-date').value = date;
        document.getElementById('reminder-form').style.display = 'block';
    }

    function hideForm() {
        document.getElementById('reminder-form').style.display = 'none';
    }
</script>
</body>
</html>

