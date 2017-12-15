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
   $search_name = htmlentities($_POST['keyword']);

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
   <!--<link rel="stylesheet" type="text/css" href="searchstyle.css"> -->
   <link rel="stylesheet" type="text/css" href="node_modules/semantic-ui-dropdown/dropdown.min.css">
   <link rel="stylesheet" type="text/css" href="node_modules/semantic-ui/dist/semantic.min.css">
   <script src="jquery-3.2.1.min.js"></script>
   <script src="node_modules/semantic-ui/dist/components/transition.min.js"></script>
   <script src="node_modules/semantic-ui-dropdown/dropdown.min.js"></script>
</head>
<body>
      <div>
         <div>
            <h1 style="text-align:center;"> Search Employee </h1>
            <div>
               <!-- <form action="searchEmployee.php" method="POST">
                  <input type="text" id="name" name="Name" value="" placeholder="Namn" onkeyup="showHint(this.value)"/>
                  <input type="submit" value="Sök" />
               </form>
               -->
               <form action="#" method="POST">
                  <div>
                     <div style="width:30%; margin:auto;">
                        <div class="ui form">
                            <div class="two fields">
                             <div class="field">
                               <select multiple="" class="ui fluid search selection dropdown" name="keyword" onkeyup="showHint(this.value)">
                                 <option value="">Select Country</option>
                                 <option value="AF">Afghanistan</option>
                                 <option value="AX">Åland Islands</option>
                                 <option value="AL">Albania</option>
                                 <option value="DZ">Algeria</option>
                                 <option value="AS">American Samoa</option>
                                 <option value="AD">Andorra</option>
                                 <option value="AO">Angola</option>
                                 <option value="AI">Anguilla</option>
                                 <option value="AQ">Antarctica</option>
                               </select>
                             </div>
                             <div class="field">
                                <button class="fluid ui button" type="submit">Submit</button>
                             </div>
                           </div>
                          </div>
                      </div>
                 </div>
              </form>

             <div>
               <h2> Sökresultat</h2>
               <p id="txtHint"></p>
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
      $(document).ready(function(){
         $('.ui.dropdown').dropdown();
      });
   </script>

   <script>
   function showHint(str) {
   console.log("ASDheyyyyyyy");
     var xhttp;
     if (str.length == 0) {
       document.getElementById("txtHint").innerHTML = ""; //slow?
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
      var xmlDoc = xml.responseXML;
      var allWords = xmlDoc.getElementsByTagName("MATCHINGWORDS")[0];

      document.getElementById("txtHint").innerHTML = ""; //slow? Remove elements before adding
      if(allWords.hasChildNodes()){
         for(var word = allWords.firstChild; word !== null; word = word.nextSibling) {
            var node = document.createElement("SPAN");
            var textnode = document.createTextNode(word.childNodes[0].nodeValue);
            node.appendChild(textnode);
            document.getElementById("txtHint").appendChild(node);
         }
      }
   }
   </script>

</body>
</html>
