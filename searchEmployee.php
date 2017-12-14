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
   <link rel="stylesheet" type="text/css" href="node_modules/semantic-ui-dropdown/dropdown.min.css">
   <link rel="stylesheet" type="text/css" href="node_modules/semantic-ui/dist/semantic.min.css">
   <script src="jquery-3.2.1.js"></script>
   <script src="node_modules/semantic-ui/dist/components/transition.min.js"></script>
   <script src="node_modules/semantic-ui-dropdown/dropdown.min.js"></script>
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

x
   <script>
      $(document).ready(function(){
         $('.ui.dropdown')
         .dropdown();
      });
   </script>

   <div class="ui dropdown">
     <input type="hidden" name="gender">
     <i class="dropdown icon"></i>
     <div class="default text">Gender</div>
     <div class="menu">
      <div class="item" data-value="male">Male</div>
      <div class="item" data-value="female">Female</div>
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
      xmlfunction(this);
    }
  };
  xhttp.open("GET", "searchSuggestions.php?q="+str, true);
  xhttp.send();
}
</script>
<script>
function xmlfunction(xml){
   var responseString = xml.responseText;
   document.getElementById("txtHint").innerHTML = responseString;
}
</script>

</body>
</html>
