<?php include "../inc/dbinfo.inc"; ?>
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
         document.getElementById('nameError').innerHTML = "Fyll i ditt namn";
      </script>
      <?php
   }

   if(!strlen($user_address)){
      ?>
      <script>
         document.getElementById('addressError').innerHTML = "Fyll i din adress";
      </script>
      <?php
   }
   /* Validate email */
   if(!strlen($user_mail)){
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "Fyll i din Mailadress";
      </script>
      <?php
   }
   else if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "Ogiltig Mail";
      </script>
      <?php
   }
   else{
      /* check if email exist */
      /* Connect to PostGreSQL and select the database. */
      $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
      $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
      $result = pg_prepare($db_connection, "my_query", 'SELECT email FROM users WHERE email=$1');
      $result = pg_execute($db_connection, "my_query", array($user_mail));
      if(pg_num_rows($result)!=0){
         ?>
         <script>
            document.getElementById('emailError').innerHTML = "Email redan registrerad";
         </script>
         <?php
      }
   }

   if(!strlen($user_password) || !strlen($user_password2)){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Fyll i ditt lösenord";
      </script>
      <?php
   }
   else if($user_password != $user_password2){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Lösenorden matchar inte";
      </script>
      <?php
   }
}
?>
