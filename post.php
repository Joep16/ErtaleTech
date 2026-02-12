<?php

include 'db_conn.php';

if(isset($_POST['submit'])){

   $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `users`(name, email, phone, password) VALUES('$fullname', '$email', '$phone', '$pass' )") or die('query failed');

         if($insert){
            $message[] = 'registered successfully!';
            header('location:log.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }

}

?>