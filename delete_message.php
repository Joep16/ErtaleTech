<?php
include "db_conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['message_id'])) {
        $message_id = intval($_POST['message_id']);

        // Prepare and execute the deletion query
        $stmt = $conn->prepare("DELETE FROM message WHERE id = ?");
        $stmt->bind_param("i", $message_id);

        if ($stmt->execute()) {
            header("Location: leads.php"); // Redirect to the same page or wherever you prefer
            exit();
        } else {
            echo "Error deleting message.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
