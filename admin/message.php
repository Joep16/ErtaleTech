
<?php
include "db_conn.php";
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

// Process form submission to store message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['user_id'], $_POST['name'], $_POST['number'], $_POST['partner'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $partner = $_POST['partner'];

    // Insert into database
    $sql = "INSERT INTO message (user_id, name, number, partner) VALUES ('$user_id', '$name', '$number', '$partner')";
    if (mysqli_query($conn, $sql)) {
      $msg = "Message sent successfully";
      header("location: message.php?msg=" . urlencode($msg));
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Message</title>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <!-- LOGO -->
    <a class="navbar-brand fs-4" href="#">Ertale Tech</a>
    <!-- TOGGLE BUTTON -->
    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- SIDEBAR -->
    <div class="sidebar offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <!-- SIDEBAR HEADER -->
      <div class="offcanvas-header text-white border-bottom shadow-none">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Ertale Tech</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <!-- SIDEBAR BODY-->
      <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
        <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
          <li class="nav-item mx-2">
            <a class="nav-link " aria-current="page" href="customers.php">Customers</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="status.php">Sells</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link " aria-current="page" href="comments.php">Comments</a>
          </li> 
        </ul>
        <!-- Logout -->
        <div class="d-flex justify-content-center flex-lg-row align-items-center gap-3">
          <a href="status.php?logout=<?php echo $user_id; ?>" class="text-white text-decoration-none px-3 py-1 rounded-4" style="background-color: #f94ca4">LOGOUT</a>
        </div>
      </div>
    </div>
  </div>
</nav></br></br></br>

<!-- MAIN CONTENT -->
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <!-- Display message after form submission -->
      <?php if (isset($_GET["msg"])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <?php echo $_GET["msg"]; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- Form for message -->
      <form action="message.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <div class="mb-3">
          <label for="name" class="form-label text-white">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="number" class="form-label text-white">Number</label>
          <input type="text" class="form-control" id="number" name="number" required>
        </div>
        <div class="mb-3">
          <label for="partner" class="form-label text-white">partner</label>
          <textarea class="form-control" id="partner" name="partner" rows="5" required></textarea>
        </div>
        <div class="text">
          <button type="submit" class="btn btn-primary">Send Lead</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

<style>
   body {
        /* Background image with fixed position */
        background: url('image/cloud.jpg') no-repeat center center fixed;
        background-size: cover; /* Ensures the image covers the entire screen */
        background-color: rgba(0, 0, 0, 0.3); /* Optional overlay color to improve text readability */
    }

    @media (max-width: 991px) {
        .sidebar {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
    }
</style>

</html>
