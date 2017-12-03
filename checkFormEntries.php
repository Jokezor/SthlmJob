<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

   $user_name = htmlentities($_POST['Name']);
   $user_address = htmlentities($_POST['Address']);
   $user_mail = htmlentities($_POST['Mail']);
   $user_password = ($_POST['Password']);
   $user_password2 = ($_POST['Password2']);

   /* Is file chosen */
   if(empty($_FILES["fileToUpload"]["name"])){
      ?>
      <script>
         document.getElementById('fileError').innerHTML = "Välj en fil att ladda upp";
      </script>
      <?php
   }
   /* Check file size */
   else if ($_FILES["fileToUpload"]["size"] > 2000000) {
      ?>
      <script>
         document.getElementById('fileError').innerHTML = "Filen är för stor";
      </script>
      <?php
   }

   /* Allow certain file formats */
   $fileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
   else if($fileType != "doc" && $fileType != "docx" && $fileType != "pdf"
   && $fileType != "rtf" && $fileType != "txt" && $fileType != "odt" && $fileType != "wps") {
      ?>
      <script>
         document.getElementById('fileError').innerHTML = "Ej tillåten filtyp";
      </script>
      <?php
   }

   /* Check if username exists */
   if(!strlen($user_name)){
      ?>
      <script>
         document.getElementById('nameError').innerHTML = "Fyll i ditt namn";
      </script>
      <?php
   }
   /* Check if address exists */
   if(!strlen($user_address)){
      ?>
      <script>
         document.getElementById('addressError').innerHTML = "Fyll i din adress";
      </script>
      <?php
   }
   /* Check if email exists */
   if(!strlen($user_mail)){
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "Fyll i din Mailadress";
      </script>
      <?php
   }
   /* If email does exist, check if it is valid */
   else if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
      ?>
      <script>
         document.getElementById('emailError').innerHTML = "Ogiltig Mail";
      </script>
      <?php
   }
   else{
      /* check the email already exist in the database */
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
   /* Check if password is filled */
   if(!strlen($user_password) || !strlen($user_password2)){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Fyll i ditt lösenord";
      </script>
      <?php
   }
   /* Check if the two passwords match */
   else if($user_password != $user_password2){
      ?>
      <script>
         document.getElementById('passwordError').innerHTML = "Lösenorden matchar inte";
      </script>
      <?php
   }
   else{
     if (strlen($user_password) < 8 ) {
       ?>
       <script>
          document.getElementById('passwordError').innerHTML = "Lösenordet måste vara minst 8 tecken långt";
       </script>
       <?php
    }

    if (!preg_match("#[0-9]+#", $user_password)) {
      ?>
      <script>
         document.getElementById('passwordError1').innerHTML = "Lösenordet måste innehålla minst en siffra";
      </script>
        <?php
    }

    if (!preg_match("#[a-zA-Z]+#", $user_password)) {
      ?>
      <script>
         document.getElementById('passwordError2').innerHTML = "Lösenordet måste innehålla minst en bokstav";
      </script>
      <?php
    }
  }
}
?>
