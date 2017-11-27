<?php include "../inc/dbinfo.inc";
ini_set('display_startup_errors', 1);
ini_set('display_errors', On);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('html_errors', On);
?>

<html>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<body>

<?php
  /* Connect to PostGreSQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
?>

<?php
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



   if (validEntries($user_name, $user_address, $user_mail, $user_password, $user_password2)) {
        AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password_hash);
   }
}
?>

<!-- Input form -->
<form class ="formReg" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
  <table border="0">
    <tr>

    </tr>
    <tr>
      <td>
	<input type="text" name="Name" maxlength="45" size="30" value="<?php echo $user_name;?>" placeholder="Namn" />
      </td>
      <td>
	<input type="text" name="Address" maxlength="90" size="35" value="<?php echo $user_address;?>" placeholder="Adress"/>
      </td>
      <td>
  <input type="text" name="Mail" maxlength="90" size="35" value="<?php echo $user_mail;?>" placeholder="Mail Adress"/>
      </td>
      <td>
  <input type="password" name="Password" maxlength="90" size="35" placeholder="Lösenord"/>
      </td>
      <td>
  <input type="password" name="Password2" maxlength="90" size="35" placeholder="Upprepa Lösenord"/>
      </td>
  </tr>
  <tr>
  </tr>
  <tr>
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
   $result = pg_prepare($db_connection, "my_query", 'INSERT INTO users (name, address, email, password) values ($1, $2, $3, $4)');

   // Execute the prepared query.
   $result = pg_execute($db_connection, "my_query", array($user_name, $user_address, $user_mail, $user_password));

}

function validEntries($name, $address, $mail, $password, $password2){
   if(strlen($name) && strlen($address) && strlen($mail) && strlen($password) && strlen($password2)){
      if($password != $password2){
         return false;
      }
      if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
         return false;
      }
      if(0){
         return false;
      }
      return true;
   }
   else{
      return false;
   }
}
?>


</body>
</html>
