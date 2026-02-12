<?php

include 'db_conn.php';
session_start();

if (isset($_POST['submit'])) {
    // Prepare and bind
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare statement
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password_md5);
        $stmt->fetch();

        // Hash the entered password with MD5
        $entered_password_md5 = md5($password);

        // Verify the password
        if ($entered_password_md5 === $stored_password_md5) {
            $_SESSION['user_id'] = $user_id;
            header('Location: status.php?from=index');
            exit();
        } else {
            $_SESSION['message'] = 'Incorrect email or password!';
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Incorrect email or password!';
        header('Location: index.php');
        exit();
    }

    $stmt->close();
}

?>