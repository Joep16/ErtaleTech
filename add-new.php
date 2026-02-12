<?php
include "db_conn.php";
session_start();
include "navbar.php";
$user_id = $_SESSION['user_id'];

if (isset($_POST["submit"])) {
   $coname = $_POST['coname'];
   $cname = $_POST['cname'];
   $item = $_POST['item'];
   $brand = $_POST['brand'];
   $unit = $_POST['unit'];
   $price = $_POST['price'];
   $email = $_POST['email'];
   $dates = $_POST['dates'];
   $phone = $_POST['phone'];

   $sql = "INSERT INTO `sell`(`user_id`,`coname`, `cname`, `item`, `brand`, `unit`, `price`, `email`, `dates`, `phone`) VALUES ('$user_id','$coname','$cname','$item','$brand','$unit','$price','$email','$dates','$phone')";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      header("Location: status.php?msg=New record created successfully");
   } else {
      echo "Failed: " . mysqli_error($conn);
   }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <title>New entry</title>
</head>

<body>
 </br></br></br></br>

   <div class="container" style="background-color:rgba(240, 240, 240, 0.1)">
      <div class="text-center mb-4">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         ?>
</br> <h3 style="color:white">INSERT YOUR DATA</h3>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
         <div class="col">
         <input type="text" class="form-control" style="width:25vw; min-width:150px; opacity:0.001; pointer-events: none;" name="coname" value="<?php echo $fetch['name']; ?>"> 
               </div>
            <div class="col">
                  <label class="form-label"style="color:white">Customer name:</label>
                  <input type="text" class="form-control" name="cname" placeholder="abebe kebede">
               </div>
               <div class="col">
                  <label class="form-label"style="color:white">Item name:</label>
                  <input type="text" class="form-control" name="item" placeholder="car">
               </div>
               <div class="col">
                  <label class="form-label"style="color:white">Brand:</label>
                  <input type="text" class="form-control" name="brand" placeholder="Toyota">
               </div>
               <div class="col">
                  <label class="form-label"style="color:white">Unit:</label>
                  <input type="text" class="form-control" name="unit" placeholder="100">
               </div>
            <div class="col">
                  <label class="form-label"style="color:white">Price:</label>
                  <input type="text" class="form-control" name="price" placeholder="20,000$">
               </div>
            <div class="col">
               <label class="form-label"style="color:white">Email:</label>
               <input type="email" class="form-control" name="email" placeholder="name@example.com">
            </div>

            <div class="col">
                  <label class="form-label"style="color:white">Date:</label>
                  <input type="date" class="form-control" name="dates">
               </div>
               <div class="col">
                  <label class="form-label"style="color:white">Phone:</label>
                  <input type="text" class="form-control" name="phone" placeholder="09000000">
               </div></br>
            <div>
               <button type="submit" class="btn btn-success" name="submit">Save</button>
               <a href="status.php" class="btn btn-danger">Cancel</a></br></br>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
<style>
    body {
        /* Background image with fixed position */
        background: url('./assets/images/cloud.jpg') no-repeat center center fixed;
        background-size: cover; /* Ensures the image covers the entire screen */
        background-color: rgba(0, 0, 0, 0.3); /* Optional overlay color to improve text readability */
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
    @media (max-width: 991px) {
        .sidebar {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
    }
</style>
</html>