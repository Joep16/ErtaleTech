<?php
include "db_conn.php";
session_start();
include "navbar.php";
$user_id = $_SESSION['user_id'];
$search_term = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $search_term = trim($_POST['search']);
    }
}

$stmt = $conn->prepare("SELECT id, name, number, partner FROM message WHERE (name LIKE ? OR number LIKE ? OR partner LIKE ?)");
$search_param = '%' . $search_term . '%';
$stmt->bind_param("sss", $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

$messages = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Leads</title>
    <style>
        body {
            background: url('./assets/images/cloud.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: rgba(0, 0, 0, 0.3);
        }
        .card {
            margin-bottom: 20px;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with 50% opacity */
            border: 1px solid rgba(204, 204, 204, 0.7); /* Optional: light border color with 70% opacity */
            color: white; /* White text color */
        }
        .card-title {
            background-color: rgba(211, 211, 211, 0.2); /* 20% opacity for the gray color */
            padding: 10px;
            border-radius: 5px;
            width: 30%; /* Make the width 30% of its parent element */
            box-sizing: border-box; /* Ensure padding and border are included in the width */
        }
        .modal-content {
            background-color: #f8f9fa; /* Light background for the modal */
        }
        .badge-circle {
            border-radius: 50%; /* Make badge circular */
            padding: 0.5em 0.7em; /* Adjust padding to ensure it's circular */
            font-size: 0.75em; /* Adjust font size */
            height: 1.5em; /* Fixed height */
            width: 1.5em; /* Fixed width */
            display: inline-flex; /* Align text vertically */
            justify-content: center; /* Center text horizontally */
            align-items: center; /* Center text vertically */
        }
        .badge-reminder {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            margin-left: 5px;
        }
        .no-messages {
            font-size: 1.5em; /* Increase font size */
            color: white; /* Ensure text color is white */
            text-align: center; /* Center align text */
            margin-top: 20px; /* Add some margin on top */
        }
    </style>
</head>

<body>

    <div class="container mt-5 pt-5">
        <h1 class="mb-4" style="color: white">Leads</h1>

        <!-- Display Messages as Cards -->
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($message['name']); ?></h5>
                        <h5 class="card-title"><?php echo htmlspecialchars($message['number']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($message['partner'], 0, 100)); ?>...</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo $message['id']; ?>">
                            View
                        </button>
                        <form action="delete_message.php" method="post" style="display:inline;">
                            <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="messageModal<?php echo $message['id']; ?>" tabindex="-1" aria-labelledby="messageModalLabel<?php echo $message['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="messageModalLabel<?php echo $message['id']; ?>"><?php echo htmlspecialchars($message['name']); ?></h5>
                                <h5 class="modal-title" id="messageModalLabel<?php echo $message['id']; ?>"><?php echo htmlspecialchars($message['number']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><?php echo nl2br(htmlspecialchars($message['partner'])); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-messages">No Leads found.</p>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
