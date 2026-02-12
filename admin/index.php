<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ertale Tech</title>
  <link rel="stylesheet" href="./style/logstyle.css" />
  <script>
        window.onload = function() {
            // Check if there is a message in session
            <?php if (isset($_SESSION['message'])): ?>
                alert("<?php echo $_SESSION['message']; ?>");
                <?php unset($_SESSION['message']); // Clear the message after displaying ?>
            <?php endif; ?>
        };
    </script>
  <style>
    /* Modal Styles */
    .modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4); /* Black background with opacity */
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px;
  text-align: center;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}


    #termsLink {
      cursor: pointer;
      color: blue;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <main>
    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <form action="fetch.php" method="post" enctype="multipart/form-data" autocomplete="off" class="sign-in-form">
            <div class="logo">
              <img src="./image/edited.png" alt="Ertaletech" />
              <h3>Ertale Tech</h3>
            </div>

            <div class="heading">
              <h2>Welcome Back</h2>
              <h6>Not registered yet?</h6>
              <a href="#" class="toggle">Sign up</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" name="email" minlength="4" class="input-field" autocomplete="off" required />
                <label>Email</label>
              </div>

              <div class="input-wrap">
                <input type="password" name="password" minlength="4" class="input-field" autocomplete="off" required />
                <label>Password</label>
              </div>

              <input type="submit" name="submit" value="Sign In" class="sign-btn" />

              <p class="text">
                Forgotten your password or your login details?
                <a href="#">Get help</a> signing in
              </p>
            </div>
          </form>

          <form action="post.php" method="post" enctype="multipart/form-data" autocomplete="off" class="sign-up-form">
            <div class="logo">
              <img src="./image/edited.png" alt="Ertaletech" />
              <h3>Ertale Tech</h3>
            </div>

            <?php
            if(isset($message)){
               foreach($message as $message){
                  echo '<div class="message">'.$message.'</div>';
               }
            }
            ?>

            <div class="heading">
              <h2>Get Started</h2>
              <h6>Already have an account?</h6>
              <a href="#" class="toggle">Sign in</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" name="fullname" id="name" minlength="4" class="input-field" autocomplete="off" required />
                <label for="name">Company Name</label>
              </div>

              <div class="input-wrap">
                <input type="email" name="email" id="mail" class="input-field" autocomplete="off" required />
                <label for="mail">Email</label>
              </div>

              <div class="input-wrap">
                <input type="text" name="phone" id="ph" minlength="4" class="input-field" autocomplete="off" required />
                <label for="ph">Phone Number</label>
              </div>

              <div class="input-wrap">
                <input type="password" name="password" id="pass" minlength="4" class="input-field" autocomplete="off" required />
                <label for="pass">Password</label>
              </div>

              <div class="input-wrap">
                <input type="password" name="cpassword" id="cpass" minlength="4" class="input-field" autocomplete="off" required />
                <label for="cpass">Confirm Password</label>
              </div>
              <div class="input-wrap">
                <input type="checkbox" id="agreeTerms" required />
                I agree to the <a href="#" id="termsLink">Terms of Service</a> and <a href="#" id="termsLink">Privacy Policy</a>
              </div>
              <input type="submit" name="submit" value="Sign Up" class="sign-btn" />
            </div>
          </form>
        </div>

        <div class="carousel carousel-light">
          <div class="images-wrapper">
            <img src="./image/stock.jpg" class="image img-1 show" alt="" />
            <img src="./image/stock.jpg" class="image img-2" alt="" />
            <img src="./image/stock.jpg" class="image img-3" alt="" />
          </div>

          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>Secure Simple Fast</h2>
                <h2>Secure Simple Fast</h2>
                <h2>Secure Simple Fast</h2>
              </div>
            </div>

            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Terms of Service Modal -->
  <div id="termsModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Terms of Services</h2>
    <p>
        1. Introduction
        <br>
        At Ertale Tech, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, disclose, and protect your information in compliance with applicable laws and regulations in Ethiopia.
        <br><br>
        2. Information We Collect
        <br>
        We may collect the following types of information:
        <br>
        Personal Information: Information that identifies you, such as your name, contact details, and any other personal identifiers you provide when engaging with our services.
        <br>
        Technical Data: Information related to your use of our services, including IP addresses, browser types, access times, and usage statistics.
        <br>
        Communications Data: Information from correspondence you send us, including emails, feedback, and support inquiries.
        <br><br>
        3. How We Use Your Information
        <br>
        We use the information we collect for various purposes, including:
        <br>
        Service Delivery: To provide, maintain, and improve our data center services.
        <br>
        Communication: To communicate with you regarding your account, respond to inquiries, and provide updates.
        <br>
        Service Improvement: To analyze usage patterns and enhance our services.
        <br>
        Compliance: To comply with applicable laws, regulations, and legal requests.
        <br><br>
        4. Sharing Your Information
        <br>
        We do not sell your personal information. However, we may share your information in the following situations:
        <br>
        Service Providers: We may share information with trusted third-party vendors who assist us in providing our services and conducting our business operations.
        <br>
        Legal Obligations: We may disclose your information if required by law or in response to valid legal requests.
        <br><br>
        5. Data Security
        <br>
        We implement appropriate technical and organizational measures to safeguard your personal information against unauthorized access, disclosure, alteration, or destruction. We continuously review our security practices to ensure your data remains protected.
        <br><br>
        6. Data Retention
        <br>
        We retain your personal information only as long as necessary to fulfill the purposes outlined in this Privacy Policy or as required by law.
        <br><br>
        7. Your Rights
        <br>
        You have certain rights regarding your personal information, including:
        <br>
        Access: The right to request access to your personal information.
        <br>
        Correction: The right to request correction of any inaccurate or incomplete information.
        <br>
        Deletion: The right to request deletion of your personal information, subject to legal obligations.
        <br><br>
        8. Changes to This Privacy Policy
        <br>
        We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. We will notify you of significant changes by posting the updated policy on our website and updating the effective date.
        <br><br>
        9. Contact Us
        <br>
        If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:
        <br>
        Ertale Tech Tech Company
        <br>
        Lideta
        <br>
        @ErtaleTech.com
        <br>
        +251
        <br><br>
        10. Governing Law
        <br>
        This Privacy Policy shall be governed by and construed in accordance with the laws of Ethiopia.
      </p>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="./js/applog.js"></script>
  <script>
   // Get the modal
var modal = document.getElementById("termsModal");

// Get the link that opens the modal
var termsLink = document.getElementById("termsLink");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the link, open the modal
termsLink.onclick = function (e) {
  e.preventDefault(); // Prevent default anchor behavior
  modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

  </script>
</body>
</html>
