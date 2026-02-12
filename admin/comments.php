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
  <title>status</title>
</head>

<body>

    <!-- NAVBAR -->

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark fixed-top">
  <div class="container">

    <!-- LOGO -->

    <a class="navbar-brand fs-4" href="#">Lead Addis</a>

    <!-- TOGGLE BUTTON -->

    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- SIDEBAR -->

    <div class="sidebar offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">

    <!-- SIDEBAR HEADER -->

      <div class="offcanvas-header text-white border-bottom shadow-none">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Lead Addis</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- SIDEBAR BODY-->

      <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
        <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
        <li class="nav-item mx-2">
            <a class="nav-link" href="customers.php">Customers</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" aria-current="page" href="status.php">Sells</a>
          </li> 
          <li class="nav-item mx-2">
            <a class="nav-link active" aria-current="page" href="cimments.php">Comments</a>
          </li> 
        </ul>
        
        <!-- Logout -->

        <div class="d-flex justify-content-center flex-lg-row align-items-center gap-3">
            <a href="status.php?logout=<?php echo $user_id; ?>" class="text-white text-decoration-none px-3 py-1 rounded-4" style="background-color: #f94ca4">LOGOUT</a>
      </div>
    </div>
  </div>
</nav></br></br></br></br>

  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    
    <form class="d-flex" action="" method="GET">
      <div class="input-group mb-3">
        <input class="form-control me-2" name="search" type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" placeholder="Search" aria-label="Search">
        <button class="btn btn-dark" type="submit">Search</button>
       </div>
      </form></br>
    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
         
        <th scope="col">first name</th>
          <th scope="col">last name</th>
          <th scope="col">email</th>
          <th scope="col">subject</th>
          <th scope="col">message</th>
        
          
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT * FROM `comments`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr class="table-light">
            
            <td><?php echo $row["firstname"] ?></td>
            <td><?php echo $row["lastname"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["subject"] ?></td>
            <td><?php echo $row["message"] ?></td>
           
         </tr>
        <?php
        }
        ?>


<!-- SEARCH-->
<?php
$con = mysqli_connect("localhost", "root","","log");
if(isset($_GET['search']))
{
  
  $filtervalues = $_GET['search'];
  $query = "SELECT * FROM comments WHERE CONCAT(firstname,lastname,email,subject,message) LIKE '%$filtervalues%'";
  $query_run = mysqli_query($con, $query);

  if(mysqli_num_rows($query_run) > 0)
  {
    foreach($query_run as $items)
    {
      ?>
       <tr class="table-light">
            
            <td><?= $items["firstname"] ?></td>
            <td><?= $items["lastname"] ?></td>
            <td><?= $items["email"] ?></td>
            <td><?= $items["subject"] ?></td>
            <td><?= $items["message"] ?></td>
            
    </tr>
      <?php
    }
    }
  else
  {
    ?>
    <tr class="table-light">
    <td clospan="5">No record found </td>
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
    body{
        background: url('image/cloud.jpg') rgba(0,0,0,0.3);
    }
    @media (max-width: 991px){
        .sidebar {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
    }
</style>
</html>
