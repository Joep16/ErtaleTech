<?php
include "db_conn.php";
session_start();
include "navbar.php";
$user_id = $_SESSION['user_id'];
$search_term = '';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search']))
{
  $search_term = trim($_POST['search']);
}



  $stmt = $conn->prepare("SELECT id, cname, item, brand, unit, price, email, dates, phone FROM sell WHERE user_id = ? AND (cname LIKE ? OR item LIKE ? OR brand LIKE ? OR unit LIKE ? OR price LIKE ? OR email LIKE ? OR dates LIKE ? OR phone LIKE ?)");
  $search_param = '%'. $search_term . '%';
  $stmt->bind_param("issssssss", $user_id, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
  $stmt->execute();
  $result = $stmt->get_result();


if($result->num_rows > 0){
  $sellitem = $result->fetch_all(MYSQLI_ASSOC);
}
else{
 $sellitem = [];
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

   </br></br></br></br>

  <div class="container">
   


    <a href="add-new.php" class="btn btn-dark mb-3">Add New</a>
    <form class="d-flex" action="" method="POST">
      <div class="input-group mb-3">
        <input class="form-control me-2" name="search" type="text" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Search" aria-label="Search">
        <button class="btn btn-dark" type="submit">Search</button>
       </div>
      </form></br>
     
     <?php if (!empty($sellitem)): ?>
      
    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
         
          <th >customer name</th>
          <th >item</th>
          <th >brand</th>
          <th >unit</th>
          <th >price</th>
          <th >email</th>
          <th >date</th>
          <th >phone</th>
          <th >Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sellitem as $item): ?> 
          <tr class="table-light">
            
            <td><?php echo htmlspecialchars($item['cname']); ?></td>
            <td><?php echo htmlspecialchars($item["item"]); ?></td>
            <td><?php echo htmlspecialchars($item["brand"]); ?></td>
            <td><?php echo htmlspecialchars($item["unit"]); ?></td>
            <td><?php echo htmlspecialchars($item["price"]); ?></td>
            <td><?php echo htmlspecialchars($item["email"]); ?></td>
            <td><?php echo htmlspecialchars($item["dates"]); ?></td>
            <td><?php echo htmlspecialchars($item["phone"]); ?></td>
            <td>
              <a href="edit.php?id=<?php echo $item["id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="delete.php?id=<?php echo $item["id"] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <?php else:?>
      <p>NO RESULT FOUND.</p>
    <?php endif; ?>
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
