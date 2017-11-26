<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

   $user_name = htmlentities($_POST['Namn']);
   $user_address = htmlentities($_POST['Adress']);
   $user_mail = htmlentities($_POST['Mail']);
   $user_password = ($_POST['Lösenord']);

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
   if(!strlen($user_mail)){
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "email cannot be empty";
      </script>
      <?php
   }
   if(!strlen($user_password)){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Password cannot be empty";
      </script>
      <?php
   }
}
?>
