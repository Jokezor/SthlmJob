<?php include "../inc/dbinfo.inc";?>
<?php
  /* Connect to PostGreSQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
?>

<?php
$user_name = "";   $user_address = "";   $user_mail = "";

 /* If input fields are populated, add a row to the Users table. */
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    /* If method is post, scroll page to register */
    ?>
    <script type="text/javascript">
    window.location = "#register";
    </script>
    <?php
    $user_name = htmlentities($_POST['Name']);
    $user_address = htmlentities($_POST['Address']);
    $user_mail = htmlentities($_POST['Mail']);
    $user_password = ($_POST['Password']);
    $user_password2 = ($_POST['Password2']);
    $user_password_hash = hash('sha256', $user_password);


   if (validEntries($db_connection, $user_name, $user_address, $user_mail, $user_password, $user_password2)) {
      /* Upload CV to S3 */
      if(uploadCV()){
         /* Add user to redshift db */
         if(AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password_hash)){
            echo "PROFIL REGISTRERAD!";
         } else {
            echo "Error adding user to database";
         }
      } else {
         echo "Error uploading CV";
      }
   } else {
      /* print error messages */
      include "checkFormEntries.php";
   }
}
?>

<!-- Input form -->
<!-- HTML table -->
<form class ="formReg" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
  <table id="registerTable" border="0">
    <tr>
      <td>
	<input type="text" id="name" name="Name" maxlength="45" size="30%" value="<?php echo $user_name;?>" placeholder="Namn" required/>
      </td>
      <td>
	<input type="text" id="address" name="Address" maxlength="90" size="30%" value="<?php echo $user_address;?>" placeholder="Adress" required/>
      </td>
      <td>
  <input type="email" id="mail" name="Mail" maxlength="90" size="30%" value="<?php echo $user_mail;?>" placeholder="Mail Adress" required/>
      </td>
      <td>
  <input type="password" id="password" name="Password" maxlength="90" size="30%" placeholder="Lösenord" oninput="checkIfPasswordValid(this)" required/>
      </td>
      <td>
  <input type="password" id="password2" name="Password2" maxlength="90" size="30%" placeholder="Upprepa Lösenord" oninput="checkIfPasswordsEqual(this)" required/>
      </td>
  </tr>
  <tr>
      <td>
      </td>
      <td>
      </td>
      <td>
      </td>
      <td>
         <input type="file" id="fileToUpload" name="fileToUpload" required/>
      </td>
      <td>
	<input type="submit" value="Ladda upp profil och registrera" />
      </td>
  </tr>
</table>
</form>

<?php
/* Closing connection */
pg_close($db_connection);
?>


<?php
function AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password){
   // Prepare a query for execution
   $result = pg_prepare($db_connection, "addUser_query", 'INSERT INTO users (name, address, email, password) values ($1, $2, $3, $4)');
   if(!$result){
      return false;
   }

   // Execute the prepared query.
   $result = pg_execute($db_connection, "addUser_query", array($user_name, $user_address, $user_mail, $user_password));
   if(!$result){
      return false;
   }
   pg_free_result($result);
   return true;
}

function validEntries($db_connection, $name, $address, $mail, $password, $password2){
   /* Check that all fields are filled */
   if(!strlen($name) || !strlen($address) || !strlen($mail) || !strlen($password) || !strlen($password2)){
      return false;
   }
   /* Check that passwords are valid */
   if($password != $password2){
      return false;
   }
   if (strlen($password) < 8 ) {
     return false;
   }
   if (!preg_match("#[0-9]+#", $password)) {
     return false;
   }
   if (!preg_match("#[a-zA-Z]+#", $password)) {
     return false;
   }
   /* Is valid email */
   if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
      return false;
   }
   /* If email already exist */
   $result = pg_prepare($db_connection, "validEntries_query", 'SELECT email FROM users WHERE email=$1');
   $result = pg_execute($db_connection, "validEntries_query", array($mail));
   if(pg_num_rows($result)!=0){
      return false;
   }
   /* Is file chosen */
   if(empty($_FILES["fileToUpload"]["name"])){
      return false;
   }
   /* Check file size */
   if ($_FILES["fileToUpload"]["size"] > 2000000) {
      return false;
   }
   /* Allow only certain file formats */
   $fileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
   if($fileType != "doc" && $fileType != "docx" && $fileType != "pdf"
   && $fileType != "rtf" && $fileType != "txt" && $fileType != "odt" && $fileType != "wps") {
       return false;
   }


   /* If no error occurred */
   return true;
}

function uploadCV(){

   $target_dir = "/var/www/html/uploads/";
   $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
   // Need to get email and remove @ and the dot before the ex .com to com
   // First test with just $user_mail instead of targetfile $target_dir.$user_mail.$fileType
   $user_mail = htmlentities($_POST['Mail']);
   $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
   $user_mail_tofile = $target_dir . $user_mail . "." . $fileType;

   // Testing with $user_mail_tofile instead of $target_file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $user_mail_tofile)) {
        return true;
    }
    else {
        return false;
    }
}
?>
