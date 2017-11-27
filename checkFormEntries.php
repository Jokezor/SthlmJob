<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){


   $user_name = htmlentities($_POST['Name']);
   $user_address = htmlentities($_POST['Address']);
   $user_mail = htmlentities($_POST['Mail']);
   $user_password = ($_POST['Password']);
   $user_password2 = ($_POST['Password2']);

   if(!strlen($user_name)){
      ?>
      <script>
         document.getElementById('nameError').innerHTML = "Name cannot be empty";
      </script>
      <?php
   }

   if(!strlen($user_address)){
      ?>
      <script>
         document.getElementById('addressError').innerHTML = "Address cannot be empty";
      </script>
      <?php
   }
   /* Validate email */
   if(!strlen($user_mail)){
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "email cannot be empty";
      </script>
      <?php
   }
   else if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "Invalid Email format";
      </script>
      <?php
   }

   if(!strlen($user_password) || !strlen($user_password2)){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Password cannot be empty";
      </script>
      <?php
   }
   else if($user_password != $user_password2){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Passwords does not match";
      </script>
      <?php
   }
}
?>
