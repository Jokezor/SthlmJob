<?php
/* Connect to MySQL and select the database. */
$conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
$db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());

?>


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
