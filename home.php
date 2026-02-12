<?php
include "db_conn.php";  // Make sure this file establishes a connection to the database
session_start();
include "navbar.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: log.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: log.php');
    exit();
}

// Check if the user came from log.php
$from_log = isset($_GET['from']) && $_GET['from'] === 'log';

// Handle adding new motivation
if (isset($_POST['add_motivation'])) {
    $new_motivation = mysqli_real_escape_string($conn, $_POST['new_motivation']);
    if (!empty($new_motivation)) {
        $query = "INSERT INTO motivation (motivation, user_id) VALUES ('$new_motivation', '$user_id')";
        if (!mysqli_query($conn, $query)) {
            die('Query failed: ' . mysqli_error($conn));
        }
        header('Location: home.php');
        exit();
    }
}

// Handle deleting motivation
if (isset($_GET['delete_motivation'])) {
    $motivation_id = intval($_GET['delete_motivation']);
    $query = "DELETE FROM motivation WHERE id = '$motivation_id' AND user_id = '$user_id'";
    if (!mysqli_query($conn, $query)) {
        die('Query failed: ' . mysqli_error($conn));
    }
    header('Location: home.php');
    exit();
}

// Fetch user details
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
$fetch = mysqli_fetch_assoc($result);

// Fetch reminders for today
$today = date('Y-m-d');
$query = "SELECT id, reminder FROM reminders WHERE date = '$today' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
$reminders = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle reminder deletion
if (isset($_GET['delete_reminder'])) {
    $reminder_id = intval($_GET['delete_reminder']);
    $query = "DELETE FROM reminders WHERE id = '$reminder_id'";
    if (!mysqli_query($conn, $query)) {
        die('Query failed: ' . mysqli_error($conn));
    }
    header('Location: home.php');
    exit();
}

// Fetch messages
$query = "SELECT id, name, number, partner FROM message";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch motivations
$query = "SELECT id, motivation FROM motivation WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
$motivations = mysqli_fetch_all($result, MYSQLI_ASSOC);

$user_name = $fetch['name']; // Assuming 'name' field contains user's name
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/homestyle.css">
    <title>Dashboard</title>
</head>
<body>
<main>
    <div class="main-container <?php echo $from_log ? 'hidden' : ''; ?>">
        <div class="sidebar-content">
            <div class="main-section">
                <h3>Today's Reminders</h3>
                <?php if (!empty($reminders)): ?>
                    <ul class="list-group">
                        <?php foreach ($reminders as $reminder): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($reminder['reminder']); ?>
                                <a href="home.php?delete_reminder=<?php echo $reminder['id']; ?>" class="btn-close" aria-label="Close">×</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No reminders for today.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="motivation-content">
            <div class="main-section">
                <h3>Daily Motivation</h3>
                <?php if (!empty($motivations)): ?>
                    <ul class="list-group">
                        <?php foreach ($motivations as $motivation): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($motivation['motivation']); ?>
                                <a href="home.php?delete_motivation=<?php echo $motivation['id']; ?>" class="btn-close" aria-label="Close">×</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No motivation available.</p>
                <?php endif; ?>
                <form method="post" action="home.php" class="textarea-wrapper">
                    <textarea name="new_motivation" placeholder="Enter new motivation..."></textarea>
                    <button type="submit" name="add_motivation" class="btn-add">
                        <i class="fas fa-plus"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="right-sidebar-content">
            <div class="main-section">
                <h3>Leads</h3>
                <?php if (!empty($messages)): ?>
                    <ul class="list-group">
                        <?php foreach ($messages as $message): ?>
                            <li class="list-group-item" data-message-id="<?php echo $message['id']; ?>">
                                <strong style="display: block; background-color: rgba(0, 0, 0, 0.2); padding: 0; margin: 0; text-align: left">name: <?php echo htmlspecialchars($message['name']); ?></strong>
                                <strong style="display: block; background-color: rgba(0, 0, 0, 0.2); padding: 0; margin: 0; text-align: left">number: <?php echo htmlspecialchars($message['number']); ?></strong>
                                <p><?php echo htmlspecialchars($message['partner']); ?></p>
                                <button class="btn-hide" onclick="hideMessage(this)">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No messages available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Popup container -->
<div id="popup" class="popup <?php echo $from_log ? '' : 'hidden'; ?>">
    <h1>Welcome Back</h1>
    <p>Enjoy your experience</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function hideMessage(button) {
        var listItem = button.parentElement;
        listItem.style.display = 'none';

        var messageId = listItem.getAttribute('data-message-id');
        var hiddenMessages = JSON.parse(localStorage.getItem('hiddenMessages')) || [];
        if (!hiddenMessages.includes(messageId)) {
            hiddenMessages.push(messageId);
            localStorage.setItem('hiddenMessages', JSON.stringify(hiddenMessages));
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var hiddenMessages = JSON.parse(localStorage.getItem('hiddenMessages')) || [];
        var listItems = document.querySelectorAll('.list-group-item');
        listItems.forEach(function (item) {
            var messageId = item.getAttribute('data-message-id');
            if (hiddenMessages.includes(messageId)) {
                item.style.display = 'none';
            }
        });

        if (<?php echo $from_log ? 'true' : 'false'; ?>) {
            var mainContainer = document.querySelector('.main-container');
            var popup = document.getElementById('popup');

            mainContainer.classList.add('hidden');
            popup.classList.remove('hidden');

            setTimeout(function () {
                popup.classList.add('fadeOut');
                setTimeout(function () {
                    popup.classList.add('hidden');
                    mainContainer.classList.remove('hidden');
                }, 1000);
            }, 6000);
        }
    });
</script>

</body>
</html>
