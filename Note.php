<?php
include "db_conn.php";
session_start();
include "navbar.php";
$user_id = $_SESSION['user_id'];
$search_term = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Handle deleting a note
        $note_id = $_POST['delete_id'];

        $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $note_id, $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to avoid form resubmission
        header("Location: note.php");
        exit();
    } elseif (isset($_POST['search'])) {
        $search_term = trim($_POST['search']);
    } elseif (isset($_POST['title']) && isset($_POST['content'])) {
        // Handle adding new note
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);

        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);
        $stmt->execute();
        $stmt->close();

        // Redirect to avoid form resubmission
        header("Location: note.php");
        exit();
    }
}

$stmt = $conn->prepare("SELECT id, title, content FROM notes WHERE user_id = ? AND (title LIKE ? OR content LIKE ?)");
$search_param = '%' . $search_term . '%';
$stmt->bind_param("iss", $user_id, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

$notes = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

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
    <title>Notes</title>
    <style>
        body {
            background: url('./assets/images/cloud.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: rgba(0, 0, 0, 0.3);
        }
        .container-wrapper {
            background: rgba(255, 255, 255, 0.6); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            width: 80%; /* Adjust width as needed */
            max-width: 900px; /* Maximum width for larger screens */
            margin: 0 auto; /* Center horizontally */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: add shadow for better visibility */
        }
        .card {
            margin-bottom: 20px;
            background-color: #d3d3d3; /* Gray background color */
            border: 1px solid #ccc; /* Optional: light border color */
        }
        .card-title {
            background-color: #f0f0f0; /* Change this color as desired */
            padding: 10px;
            border-radius: 5px;
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
            margin-left: 5px; /* Space between text and dot */
        }
    </style>
</head>

<body>
    </br></br></br></br>
    <div class="container-wrapper mt-5 pt-5">
        <h1 class="mb-4 text-center">Notes</h1>

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addNoteModal">
            Add New Note
        </button>

        <!-- Add New Note Modal -->
        <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNoteModalLabel">Add New Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="note.php" method="POST">
                            <div class="mb-3">
                                <label for="noteTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="noteTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="noteContent" class="form-label">Content</label>
                                <textarea class="form-control" id="noteContent" name="content" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark">Add Note</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <form class="d-flex mb-4" action="note.php" method="POST">
            <div class="input-group">
                <input class="form-control me-2" name="search" type="text" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Search notes" aria-label="Search">
                <button class="btn btn-dark" type="submit">Search</button>
            </div>
        </form>

        <!-- Display Notes as Cards -->
        <?php if (!empty($notes)): ?>
            <?php foreach ($notes as $note): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($note['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($note['content'], 0, 100)); ?>...</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#noteModal<?php echo $note['id']; ?>">
                            View More
                        </button>
                        <!-- Delete Button -->
                        <form action="note.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $note['id']; ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="noteModal<?php echo $note['id']; ?>" tabindex="-1" aria-labelledby="noteModalLabel<?php echo $note['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="noteModalLabel<?php echo $note['id']; ?>"><?php echo htmlspecialchars($note['title']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-dark">No notes found.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
