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

  /* Connect to MySQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());

?>

<?php
 /* If input fields are populated, add a row to the Users table. */
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    ?>
    <script type="text/javascript">
    window.location = "#register";
    </script>
    <?php
    $user_name = htmlentities($_POST['Namn']);
    $user_address = htmlentities($_POST['Adress']);
    $user_mail = htmlentities($_POST['Mail']);
    $user_password = ($_POST['Lösenord']);
    $user_password = hash('sha256', $user_password);



    if (strlen($user_name) && strlen($user_address) && strlen($user_mail) && strlen($user_password)) {
      AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password);
    }
}
?>

<!-- Input form -->
<form class ="formReg" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
  <table border="0">
    <tr>
      <td>Namn</td>
      <td>Adress</td>
      <td>Mail</td>
      <td>Lösenord</td>
    </tr>
    <tr>
      <td>
	<input type="text" name="Namn" maxlength="45" size="30" value="<?php echo $user_name;?>" />
      </td>
      <td>
	<input type="text" name="Adress" maxlength="90" size="35" value="<?php echo $user_address;?>"/>
      </td>
      <td>
  <input type="text" name="Mail" maxlength="90" size="35" value="<?php echo $user_mail;?>"/>
      </td>
      <td>
  <input type="password" name="Lösenord" maxlength="90" size="35" />
      </td>
      <td>
  </tr>
  <tr>
  <input type="password" name="Upprepa" maxlength="90" size="35" />
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
   $result = pg_prepare($db_connection, "my_query", 'INSERT INTO users (name, address, email, password) values ($1, $2, $3, $4)');

   // Execute the prepared query.
   $result = pg_execute($db_connection, "my_query", array($user_name, $user_address, $user_mail, $user_password));

}
?>


</body>
</html>
