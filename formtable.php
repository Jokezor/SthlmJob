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
        AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password_hash);
        echo "PROFIL REGISTRERAD!";
   }
   else{
      // print error messages
      include "checkFormEntries.php";
   }
}
?>

<!-- Input form -->
<!-- HTML table -->
<form class ="formReg" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
  <table id="registerTable" border="0">
    <tr>

    </tr>
    <tr>
      <td>
	<input type="text" name="Name" maxlength="45" size="30%" value="<?php echo $user_name;?>" placeholder="Namn" />
      </td>
      <td>
	<input type="text" name="Address" maxlength="90" size="30%" value="<?php echo $user_address;?>" placeholder="Adress"/>
      </td>
      <td>
  <input type="text" name="Mail" maxlength="90" size="30%" value="<?php echo $user_mail;?>" placeholder="Mail Adress"/>
      </td>
      <td>
  <input type="password" name="Password" maxlength="90" size="30%" placeholder="Lösenord"/>
      </td>
      <td>
  <input type="password" name="Password2" maxlength="90" size="30%" placeholder="Upprepa Lösenord"/>
      </td>
  </tr>
  <tr>
  </tr>
  <tr>
      <td>
      </td>
      <td>
      </td>
      <td>
      </td>
      <td>
      </td>
      <td>
	<input type="submit" value="Ladda upp profil och registrera" />
      </td>
  </tr>
</table>
</form>



<!-- Clean up. -->
<?php
// Free resultset
//pg_free_result($result);

// Closing connection
pg_close($db_connection);
?>



<!-- Functions  -->
<?php
function AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password){

   // Prepare a query for execution
   $result = pg_prepare($db_connection, "addUser_query", 'INSERT INTO users (name, address, email, password) values ($1, $2, $3, $4)');

   // Execute the prepared query.
   $result = pg_execute($db_connection, "addUser_query", array($user_name, $user_address, $user_mail, $user_password));
}

function validEntries($db_connection, $name, $address, $mail, $password, $password2){
   if(strlen($name) && strlen($address) && strlen($mail) && strlen($password) && strlen($password2)){
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

      if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
         return false;
      }
      // Prepare a query for execution and execute the prepared query.
      $result = pg_prepare($db_connection, "validEntries_query", 'SELECT email FROM users WHERE email=$1');
      $result = pg_execute($db_connection, "validEntries_query", array($mail));
      if(pg_num_rows($result)!=0){
         return false;

      }
      return true;
   }
   else{
      return false;
   }
}
/* Check if password is strong enough */
function isPasswordStrong($password){
   return true;
}
?>
