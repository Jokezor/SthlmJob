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
	<input type="text" name="Adress" maxlength="45" size="60" />
      </td>
      <td>
  <input type="text" name="Mail" maxlength="45" size="60" />
      </td>
      <td>
  <input type="text" name="Lösenord" maxlength="45" size="60" />
      </td>
      <td>

	<input type="submit" value="Add Data" />
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

</table>

<!-- Clean up. -->
<?php
// Free resultset
//pg_free_result($result);

// Closing connection
pg_close($db_connection);
?>


</body>
</html>
