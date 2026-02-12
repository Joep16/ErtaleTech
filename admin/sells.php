<?php
include "db_conn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
   header('location:index.php');
   exit();
}

$user_id = $_SESSION['user_id'];

// Check if user_id is passed in the URL and update $user_id
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
}

// Logout
if (isset($_GET['logout'])) {
   session_destroy();
   header('location:index.php');
   exit();
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

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <title>Status</title>
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
            <a class="nav-link" href="customers.php">Customers</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link active" aria-current="page" href="status.php">Sells</a>
          </li> 
          <li class="nav-item mx-2">
            <a class="nav-link" aria-current="page" href="comments.php">Comments</a>
          </li> 
        </ul>

        <!-- Logout -->
        <div class="d-flex justify-content-center flex-lg-row align-items-center gap-3">
          <a href="status.php?logout=<?php echo htmlspecialchars($user_id); ?>" class="text-white text-decoration-none px-3 py-1 rounded-4" style="background-color: #f94ca4">LOGOUT</a>
        </div>
      </div>
    </div>
  </div>
</nav>

<br><br><br><br>

<div class="container">
  <?php
  if (isset($_GET["msg"])) {
    $msg = htmlspecialchars($_GET["msg"]);
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>
  
  <form class="d-flex" action="" method="GET">
    <div class="input-group mb-3">
      <input class="form-control me-2" name="search" type="text" value="<?php if(isset($_GET['search'])){ echo htmlspecialchars($_GET['search']); } ?>" placeholder="Search" aria-label="Search">
      <button class="btn btn-dark" type="submit">Search</button>
    </div>
  </form>
  
  <br>
  
  <table class="table table-hover text-center">
    <thead class="table-dark">
      <tr>
        <th scope="col">Customer Name</th>
        <th scope="col">Item</th>
        <th scope="col">Brand</th>
        <th scope="col">Unit</th>
        <th scope="col">Price</th>
        <th scope="col">Email</th>
        <th scope="col">Date</th>
        <th scope="col">Phone</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Handle normal data fetching
      $sql = "SELECT * FROM `sell` WHERE user_id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, 'i', $user_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <tr class="table-light">
          <td><?php echo htmlspecialchars($row["cname"]); ?></td>
          <td><?php echo htmlspecialchars($row["item"]); ?></td>
          <td><?php echo htmlspecialchars($row["brand"]); ?></td>
          <td><?php echo htmlspecialchars($row["unit"]); ?></td>
          <td><?php echo htmlspecialchars($row["price"]); ?></td>
          <td><?php echo htmlspecialchars($row["email"]); ?></td>
          <td><?php echo htmlspecialchars($row["dates"]); ?></td>
          <td><?php echo htmlspecialchars($row["phone"]); ?></td>
        </tr>
      <?php
        }
      } else {
        echo '<tr class="table-light"><td colspan="8">No records found</td></tr>';
      }
      ?>

      <!-- SEARCH -->
      <?php
      if (isset($_GET['search'])) {
        $filtervalues = htmlspecialchars($_GET['search']);
        $query = "SELECT * FROM sell WHERE user_id = ? AND CONCAT(cname, item, brand, unit, price, dates) LIKE ?";
        $stmt = mysqli_prepare($conn, $query);
        $searchTerm = "%$filtervalues%";
        mysqli_stmt_bind_param($stmt, 'is', $user_id, $searchTerm);
        mysqli_stmt_execute($stmt);
        $query_run = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($query_run) > 0) {
          while ($items = mysqli_fetch_assoc($query_run)) {
            ?>
            <tr class="table-light">
              <td><?= htmlspecialchars($items["cname"]); ?></td>
              <td><?= htmlspecialchars($items["item"]); ?></td>
              <td><?= htmlspecialchars($items["brand"]); ?></td>
              <td><?= htmlspecialchars($items["unit"]); ?></td>
              <td><?= htmlspecialchars($items["price"]); ?></td>
              <td><?= htmlspecialchars($items["email"]); ?></td>
              <td><?= htmlspecialchars($items["dates"]); ?></td>
              <td><?= htmlspecialchars($items["phone"]); ?></td>
            </tr>
            <?php
          }
        } else {
          ?>
          <tr class="table-light">
            <td colspan="8">No record found</td>
          </tr>
          <?php
        }
      }
      ?>
    </tbody>
  </table>
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
