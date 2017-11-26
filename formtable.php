<?php include "../inc/dbinfo.inc"; ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
?>
<html>
<body>

<?php

  /* Connect to MySQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());

?>

<?php
 /* If input fields are populated, add a row to the Employees table. */
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_name = htmlentities($_POST['Namn']);
    $user_address = htmlentities($_POST['Adress']);
    $user_mail = htmlentities($_POST['Mail']);
    $user_password = htmlentities($_POST['Lösenord']);
 }

 if (strlen($user_name) && strlen($user_address) && strlen($user_mail) && strlen($user_password)) {
   AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password);
 }
 else{
    echo "Alla fält!";
}

?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>Namn</td>
      <td>Adress</td>
      <td>Mail</td>
      <td>Lösenord</td>
    </tr>
    <tr>
      <td>
	<input type="text" name="Namn" maxlength="45" size="30" />
      </td>
      <td>
	<input type="text" name="Adress" maxlength="90" size="40" />
      </td>
      <td>
  <input type="text" name="Mail" maxlength="90" size="40" />
      </td>
      <td>
  <input type="text" name="Lösenord" maxlength="90" size="40" />
      </td>
      <td>

	<input type="submit" value="Ladda upp profil och registrera" />
</td>
  </tr>
</table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
<tr>
  <td>ID</td>
  <td>Name</td>
  <td>Address</td>
  <td>Mail</td>
  <td>Lösenord</td>
</tr>

<?php
   $result = pg_query($db_connection, "SELECT * FROM users");
   while($query_data = pg_fetch_row($result)){
      echo "<tr>";
      echo "<td>",$query_data[0], "</td>",
           "<td>",$query_data[1], "</td>",
           "<td>",$query_data[2], "</td>",
           "<td>",$query_data[3], "</td>",
           "<td>",$query_data[4], "</td>";
      echo "</tr>";
   }

?>

</table>

<!-- Clean up. -->
<?php
// Free resultset
//pg_free_result($result);

// Closing connection
pg_close($db_connection);
?>

<?php
function AddUser($db_connection, $user_name, $user_address, $user_mail, $user_password){

   // Prepare a query for execution
   $result = pg_prepare($db_connection, "my_query", 'INSERT INTO users (name, address, mail, password) values ($1, $2, $3, $4)');

   // Execute the prepared query.  Note that it is not necessary to escape
   // the string "Joe's Widgets" in any way
   $result = pg_execute($db_connection, "my_query", $user_name, $user_address, $user_mail, $user_password);

}
?>


</body>
</html>
