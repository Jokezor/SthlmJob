<?php include "../inc/dbinfo.inc";?>
<?php
  /* Connect to PostGreSQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
?>

<?php
 /* If input fields are populated, add a row to the Users table. */
 $search_name = "";
 if($_SERVER["REQUEST_METHOD"] == "POST"){
   $search_name = htmlentities($_POST['Name']);

    // Prepare a query for execution
   $result = pg_prepare($db_connection, "my_query", 'SELECT name, address, email FROM users WHERE name = $1');
   if(!$result){
      exit("query prepare error");
   }
   // Execute the prepared query.
   $result = pg_execute($db_connection, "my_query", array($search_name));
   if(!$result){
      exit("query execute error");
   }
}
?>



<?php
/* Closing connection */
pg_close($db_connection);
?>





<!DOCTYPE html>
<html>
<head>
   <title> Search </title>
   <link rel="stylesheet" type="text/css" href="searchstyle.css">
</head>
<body>
   <div>
      <div class ="Searchforusers">
         <h1> Search Employee </h1>
         <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
               <input type="text" id="name" name="Name" value="<?php echo $search_name;?>" placeholder="Namn" onkeyup="showHint(this.value)"/>
               <input type="submit" value="Sök" />
            </form>

            <div>
               <h2> Sökresultat</h2>
               <p>Suggestions: <span id="txtHint"></span></p>
               <div>
                  <table>
                     <?php
                     echo "<tr>";
                     echo "<th> Namn </td>";
                     echo "<th> Adress </td>";
                     echo "<th> Email </td>";
                     echo "</tr>";
                     if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if(!$result == false){
                           while ($row = pg_fetch_row($result)){
                              echo "<tr>";
                              echo "<td> $row[0] </td>";
                              echo "<td> $row[1] </td>";
                              echo "<td> $row[2] </td>";
                              echo "</tr>";
                           }
                        }
                        pg_free_result($result);
                     }
                     ?>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>



<script>
function showHint(str) {
  var xhttp;
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //document.getElementById("txtHint").innerHTML = xhttp.responseText;
      xmlfunction(this);
    }
  };
  xhttp.open("GET", "searchSuggestions.php?q="+str, true);
  xhttp.send();
}
</script>
<script>
function xmlfunction(xml){
   var xmlDoc = xml.responseXML;
   //var x = xmlDoc.getElementsByTagName("MATCHINGWORDS");
   var word1 = x[0].getElementsByTagName("MATCHINGWORDS").childNodes[0].nodeValue;
   document.getElementById("txtHint").innerHTML = word1;
}
</script>

</body>
</html>
