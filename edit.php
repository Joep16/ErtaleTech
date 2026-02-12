<?php
include "db_conn.php";
session_start();
$user_id = $_SESSION['user_id'];
$id = $_GET["id"];

// Fetch existing data for the given record ID
$select = mysqli_query($conn, "SELECT * FROM `sell` WHERE id = '$id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}

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

    $sql = "UPDATE `sell` SET `coname`='$coname', `cname`='$cname', `item`='$item', `brand`='$brand', `unit`='$unit', `price`='$price', `email`='$email', `dates`='$dates', `phone`='$phone' WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: status.php?msg=Data updated successfully");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
// Get the count of messages
$stmt = $conn->prepare("SELECT COUNT(*) as total_messages FROM message");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_messages = $row['total_messages'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Lead Addis</title>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="#">Lead Addis</a>
            <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="sidebar offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header text-white border-bottom shadow-none">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Lead Addis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
                    <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" aria-current="page" href="status.php">Sales</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link active" href="add-new.php">Add</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="cal.php">Reminders</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="note.php">Notes</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="update.php">Edit profile</a>
                        </li>
                        <li class="nav-item mx-2">
    <a class="nav-link " href="Leads.php">
        Leads 
        <?php if ($total_messages > 0): ?>
            <span class="badge bg-danger badge-circle"><?php echo $total_messages; ?></span>
        <?php endif; ?>
    </a>
</li>
                    </ul>
                    <div class="d-flex justify-content-center flex-lg-row align-items-center gap-3">
                        <a href="status.php?logout=<?php echo $user_id; ?>" class="text-white text-decoration-none px-3 py-1 rounded-4" style="background-color: #f94ca4">LOGOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </nav></br></br></br></br>

    <div class="container" style="background-color:rgba(240, 240, 240, 0.1)">
        <div class="text-center mb-4">
            </br></br><h3 style="color:white">EDIT DATA</h3>
            <p class="text-muted">Click update after changing any information</p>
        </div>
        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="col">
                    <input type="text" class="form-control" style="width:25vw; min-width:150px; opacity:0.001; pointer-events: none;" name="coname" value="<?php echo htmlspecialchars($fetch['coname']); ?>"> 
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Customer name:</label>
                    <input type="text" class="form-control" name="cname" value="<?php echo htmlspecialchars($fetch['cname']); ?>" placeholder="abebe kebede">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Item name:</label>
                    <input type="text" class="form-control" name="item" value="<?php echo htmlspecialchars($fetch['item']); ?>" placeholder="car">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Brand:</label>
                    <input type="text" class="form-control" name="brand" value="<?php echo htmlspecialchars($fetch['brand']); ?>" placeholder="Toyota">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Unit:</label>
                    <input type="text" class="form-control" name="unit" value="<?php echo htmlspecialchars($fetch['unit']); ?>" placeholder="100">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Price:</label>
                    <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($fetch['price']); ?>" placeholder="20,000$">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($fetch['email']); ?>" placeholder="name@example.com">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Date:</label>
                    <input type="date" class="form-control" name="dates" value="<?php echo htmlspecialchars($fetch['dates']); ?>">
                </div>
                <div class="col">
                    <label class="form-label" style="color:white">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($fetch['phone']); ?>" placeholder="09000000">
                </div></br>
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                    <a href="status.php" class="btn btn-danger">Cancel</a></br></br>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<style>
    body {
        background: url('./assets/images/cloud.jpg') no-repeat center center fixed;
        background-size: cover;
        background-color: rgba(0, 0, 0, 0.3);
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
    @media (max-width: 991px) {
        .sidebar {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
    }
</style>
</html>
