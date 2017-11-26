<? php

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
}
?>
