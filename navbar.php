<?php

// Start session and include database connection
include "db_conn.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);

// Fetch the count of messages
$stmt = $conn->prepare("SELECT COUNT(*) as total_messages FROM message");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_messages = $row['total_messages'];

// Fetch reminders for the logged-in user
$sql = "SELECT date FROM reminders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

$hasReminderToday = false;
$currentDay = date('Y-m-d');

while ($row = $result->fetch_assoc()) {
    if ($row['date'] === $currentDay) {
        $hasReminderToday = true;
        break; // No need to continue if we found a reminder for today
    }
}

// Fetch user name from the users table
$sql_user = "SELECT name FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user) {
    $user = $result_user->fetch_assoc();
    $user_name = $user['name'];
} else {
    die("Query failed: " . $conn->error);
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fs-4" href="#"><?php echo htmlspecialchars($user_name); ?></a>
    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="sidebar offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header text-white border-bottom shadow-none">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><?php echo htmlspecialchars($user_name); ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
        <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>" href="home.php">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'status.php') ? 'active' : ''; ?>" href="status.php">Sales</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'add-new.php') ? 'active' : ''; ?>" href="add-new.php">Add</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'cal.php') ? 'active' : ''; ?>" href="cal.php">Reminder
              <?php if ($hasReminderToday): ?>
                <span class="badge-reminder"></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'note.php') ? 'active' : ''; ?>" href="Note.php">Notes</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'update.php') ? 'active' : ''; ?>" href="update.php">Edit Profile</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link <?php echo ($current_page == 'leads.php') ? 'active' : ''; ?>" href="leads.php">Leads 
              <?php if ($total_messages > 0): ?>
                <span class="badge bg-danger badge-circle"><?php echo $total_messages; ?></span>
              <?php endif; ?>
            </a>
          </li>
        </ul>
        <div class="d-flex justify-content-center flex-lg-row align-items-center gap-3">
          <a href="log.php?logout=<?php echo $user_id; ?>" class="text-white text-decoration-none px-3 py-1 rounded-4" style="background-color: #f94ca4">LOGOUT</a>
        </div>
      </div>
    </div>
  </div>
</nav>
