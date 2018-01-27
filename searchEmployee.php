<?php include "../inc/dbinfo.inc";?>
<?php
  /* Connect to PostGreSQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
?>

<?php
 /* If input fields are populated, add a row to the Users table. */
 $search_word1[] = "";
 if($_SERVER["REQUEST_METHOD"] == "POST"){
   $search_word1 = htmlentities($_POST['keywords'][0]);
   echo $search_word1;

    // Prepare a query for execution
   $result = pg_prepare($db_connection, "my_query", 'SELECT name, address, email FROM users WHERE name = $1');
   if(!$result){
      exit("query prepare error");
   }
   // Execute the prepared query.
   $result = pg_execute($db_connection, "my_query", array($search_word1));
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
   <link rel="stylesheet" type="text/css" href="range.css">
   <link rel="stylesheet" type="text/css" href="jquery-ui.min.css">
   <!--link rel="stylesheet" type="text/css" href="rheostat-master/css/slider.css"-->


   <script src="jquery-3.2.1.min.js"></script>
   <script src="node_modules/semantic-ui/dist/components/transition.min.js"></script>
   <script src="node_modules/semantic-ui-dropdown/dropdown.min.js"></script>
   <script src="range.js"></script>
   <script src="slider.js"></script>
   <script src="jquery-ui.min.js"></script>
   <script src="node_modules/semantic-ui/dist/components/accordion.js"></script>
</head>

<body>
      <div>
         <div>
            <h1 style="text-align:center; margin-top: 5%;"> Sök Kandidater </h1>
            <div>
              <!--
               <form action="searchEmployee.php" method="POST">
                  <input type="text" id="name" name="Name" value="" placeholder="Namn" onkeyup="showHint(this.value)"/>
                  <input type="submit" value="Sök" />
               </form>
             -->
               <form action="#" method="POST">
                  <div>
                     <div style="width:90%; margin:auto; margin-top: 5%;">
                        <div class="ui form">
                          <div class="inline fields">
                            <label>Hur viktiga är egenskaperna?</label>
                            <div class="field">
                              <div class="ui radio checkbox">
                                <input type="radio" name="frequency" checked="checked">
                                <label>Måste ha</label>
                              </div>
                            </div>
                            <div class="field">
                              <div class="ui radio checkbox">
                                <input type="radio" name="frequency">
                                <label>Bra att ha</label>
                              </div>
                            </div>
                            <div class="field">
                              <div class="ui radio checkbox">
                                <input type="radio" name="frequency">
                                <label>Spelar ej roll</label>
                              </div>
                            </div>
                          </div>
                            <div class="four fields">
                             <div class="required field" style="width:20.60113%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Jobtitles</option>
                                 <option value="CR">Controller</option>
                                 <option value="SEK">Styrekonom</option>
                                 <option value="EKCE">Ekonomichef</option>
                                 <option value="EKOV">Ekonomiövervakare</option>
                                 <option value="KA">Kamrer</option>
                                 <option value="BH">Bokhållare</option>
                                 <option value="EKAS">Ekonomiassistent</option>
                                 <option value="RAKFO">Räkenskapsförare</option>
                                 <option value="REDEK">Redovisningsekonom</option>
                                 <option value="REDANS">Redovisningsansvarig</option>
                                 <option value="REDEK">Redovisningsekonom</option>
                                 <option value="REDCE">Redovisningschef</option>
                                 <option value="CFO">Chief Financial Officer</option>
                                 <option value="BSCTRL">Business Controller</option>
                                 <option value="FICTRL">Financial Controller</option>
                                 <option value="KONREDEK">Koncernredovisningsekonom</option>
                                 <option value="KONREDCE">Koncernredovisningschef</option>
                                 <option value="VDDIR">Verkställande Direktör</option>
                                 <option value="VD">VD</option>
                                 <option value="CEO">Ceo</option>
                                 <option value="DIR">Direktör</option>
                                 <option value="CE">Chef</option>
                                 <option value="FORS">Föreståndare</option>
                               </select>
                             </div>
                             <div class="required field" style="width:20.60113%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Geografiskt Område</option>
                                 <option value="STHLM">Stockholm</option>
                                 <option value="GBG">Göteborg</option>
                               </select>
                             </div>
                             <div class="required field" style="width:20.601135%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Ekonomisystem</option>
                                 <option value="BEK">Bästa ekonomi</option>
                                 <option value="UBEK">Underbar ekonomi</option>
                               </select>
                             </div>
                               <div class="required field" style="width:19.0982949%;">
                                 <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                   <option value="">Utbildning</option>
                                   <option value="CIVEK">Civilekonom</option>
                                   <option value="EK">Ekonom</option>
                                 </select>
                               </div>

                             <div class="required field" style="width:19.0982949%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Skills</option>
                                 <option value="PGR">Programmering</option>
                                 <option value="C">C</option>
                                 <option value="C#">C#</option>
                                 <option value="C++">C++</option>
                                 <option value="PY">Python</option>
                                 <option value="XCL">Excel</option>
                               </select>
                             </div>
                           </div>
                           <h2>Lönenivå</h2>
                           <div class="ui segment" style="width:40%;">
                             <div class="ui range" id="range-3"></div>
                             <br>
                              <p>
                                Minimum: <span id="display-3"></span>
                              </p>
                              <div class="ui range" id="range-4"></div>
                              <br>
                               <p>
                                 Maximum: <span id="display-4"></span>
                               </p>
                           </div>
                           <h2>Ålderspann</h2>
                           <div class="ui segment" style="width:40%;">
                             <div class="ui range" id="range-5"></div>
                             <br>
                              <p>
                                Minimum: <span id="display-5"></span>
                              </p>
                              <div class="ui range" id="range-6"></div>
                              <br>
                               <p>
                                 Maximum: <span id="display-6"></span>
                               </p>
                           </div>

                           <!--div class="ui segment" style="width:12.7321966%;">
                             <div class="ui range" id="range-4"></div>
                             <br>
                              <p>
                                Maximum: <span id="display-4"></span>
                              </p>
                           </div-->
                           <div class="field" style="width:20%;">
                              <button class="fluid ui button" type="submit">Sök efter kandidater</button>
                           </div>
                 </div>
              </form>
             <div class ="Result" style="margin-top: 5%;">
               <h2> Sökresultat</h2>
               <p id="txtHint"> </p>
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
<form>
   <h1 style="text-align: center;">Kandidater</h1>
<div id="notaccordion" class="Res">
  <label for="subscribeNews">Subscribe to newsletter?</label>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="margin-top:20px;">
  <h3 style="width:95%; margin:auto;"><a href="#">Section 1</a></h3>
  <div style="width:95%; margin:auto;">
    <p>
    Mauris mauris  ante, blandit et, ultrices a, suscipit eget, quam. Integer
    ut neque. Vivamus  nisi metus, molestie vel, gravida in, condimentum sit
    amet, nunc. Nam a  nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
    odio. Curabitur  malesuada. Vestibulum a velit eu ante scelerisque vulputate.
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%;"><a href="#">Section 2</a></h3>
  <div style="width:95%;">
    <p>
    Sed non urna. Donec et ante. Phasellus eu ligula.  Vestibulum sit amet
    purus. Vivamus hendrerit, dolor at aliquet laoreet,  mauris turpis porttitor
    velit, faucibus interdum tellus libero ac justo.  Vivamus non quam. In
    suscipit faucibus urna.
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%;"><a href="#">Section 3</a></h3>
  <div style="width:95%;">
    <p>
    Nam enim risus, molestie et, porta ac, aliquam ac,  risus. Quisque lobortis.
    Phasellus pellentesque purus in massa. Aenean in pede.  Phasellus ac libero
    ac tellus pellentesque semper. Sed ac felis. Sed  commodo, magna quis
    lacinia ornare, quam ante aliquam nisi, eu iaculis leo  purus venenatis dui.
    </p>
    <ul>
      <li>List item one</li>
      <li>List item two</li>
      <li>List item  three</li>
    </ul>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%;"><a href="#">Section 4</a></h3>
  <div style="width:95%;">
    <p>
    Cras dictum. Pellentesque habitant morbi tristique  senectus et netus
    et malesuada fames ac turpis egestas. Vestibulum ante  ipsum primis in
    faucibus orci luctus et ultrices posuere cubilia Curae;  Aenean lacinia
    mauris vel est.
    </p>
    <p>
    Suspendisse eu nisl. Nullam ut libero. Integer  dignissim consequat lectus.
    Class aptent taciti sociosqu ad litora torquent per  conubia nostra, per
    inceptos himenaeos.
     </p>
  </div>
</div>
</form>

   <div class="contact">
     Kontakt
   </div>

   <script>
      $.fn.togglepanels = function(){
      return this.each(function(){
       $(this).addClass("ui-accordion ui-accordion-icons ui-widget ui-helper-reset")
      .find("h3")
       .addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
       .hover(function() { $(this).toggleClass("ui-state-hover"); })
       .prepend('<span class="ui-icon ui-icon-triangle-1-e"></span>')
       .click(function() {
         $(this)
           .toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom")
           .find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
           .next().slideToggle();
         return false;
       })
       .next()
         .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
         .hide();
      });
      };
      $("#notaccordion").togglepanels();
   </script>

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

   <script language='javascript'>
             $(document).ready(function(){
                $('.ui.accordion').accordion();
             });
   </script>



</body>
</html>
