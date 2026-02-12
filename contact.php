<?php

include 'db_conn.php';

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Prepare and execute the SQL query to insert the new comment
    $stmt = $conn->prepare("INSERT INTO `comments` (firstname, lastname, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $subject, $message);

    if ($stmt->execute()) {
        $messages[] = 'Registered successfully!';
        header('Location: contact.php'); // Redirect to the contact page after successful insertion
        exit(); // Ensure no further code is executed
    } else {
        $messages[] = 'Registration failed!';
    }

    $stmt->close();
    $conn->close();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ertale Tech</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .modal-backdrop {
            z-index: 1040 !important;
        }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./assets/images/ertale.svg" style="width: 180px; height: 50px" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Aboutus.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>                  
                    <li class="nav-item">
                        <a class="nav-link active" href="#contact.php">Contact</a>
                    </li>
                </ul>
                <a href="log.php" class="btn btn-brand ms-lg-3">Login</a>
            </div>
        </div>
    </nav>

    <!-- CONTACT -->
    <section class="section-padding bg-light" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 text-white fw-semibold">Get in touch</h1>
                        <div class="line bg-white"></div>
                        <p class="text-white">We aim to be your trusted partner in safeguarding and managing your digital assets.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="fade-down" data-aos-delay="250">
                <div class="col-lg-8">
                    <form id="contactForm" action="contact.php" method="post" class="row g-3 p-lg-5 p-4 bg-white theme-shadow">
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" name="firstname" placeholder="Enter first name" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" name="lastname" placeholder="Enter last name" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="email" class="form-control" name="email" placeholder="Enter Email address" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="text" class="form-control" name="subject" placeholder="Enter subject" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea name="message" rows="5" class="form-control" placeholder="Enter Message" required></textarea>
                        </div>
                        <div class="form-group col-lg-12 d-grid">
                            <button type="submit" name="submit" class="btn btn-brand">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
   
  <!-- FOOTER -->
  <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">Ertale Technologies</h5>
                        <div class="line"></div>
                        <p>Ertale technology Where Innovation Meets Expertise.</p>
                        <div class="social-icons">
                            <a href="#"><i class="ri-telegram-fill"></i></a>
                            <a href="#"><i class="ri-instagram-fill"></i></a>
                            <a href="#"><i class="ri-whatsapp-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">SERVICES</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">Development</a></li>
                            <li><a href="#">Maintainance</a></li>
                            <li><a href="#">Security</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">ABOUT</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Company</a></li>
                            <li><a href="#">Career</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">CONTACT</h5>
                        <div class="line"></div>
                        <ul>
                            <li>Addis Ababa, Ethiopia</li>
                            <li>(+251) 900-00-00-00</li>
                            <li>(+251) 900-00-00-00</li>
                            <li>www.ErtaleTech.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-auto">
                        <p class="mb-0">© Copyright Ertale Technologies. All Rights Reserved 2024.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Thank You Modal -->
    <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thankYouModalLabel">Thank You!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your message has been sent successfully. We will get back to you soon!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="./assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if the PHP script indicates a successful submission
            <?php if (isset($messages) && in_array('Registered successfully!', $messages)): ?>
                var myModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
                myModal.show();
            <?php endif; ?>
        });
    </script>
</body>

</html>

