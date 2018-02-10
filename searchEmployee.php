<?php include "../inc/dbinfo.inc";?>
<?php
  /* Connect to PostGreSQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
?>

<?php
 /* If input fields are populated, add a row to the Users table. */

 if($_SERVER["REQUEST_METHOD"] == "POST"){
   $minSalary = htmlentities($_POST['minsalary']);
   $maxSalary = htmlentities($_POST['maxsalary']);
   $minAge = htmlentities($_POST['minage']);
   $maxAge = htmlentities($_POST['maxage']);
   $minExp = htmlentities($_POST['minexp']);
   $maxExp = htmlentities($_POST['maxexp']);
   $minLeave = htmlentities($_POST['minleave']);
   $maxLeave = htmlentities($_POST['maxleave']);


    // Prepare a query for execution
   $result = pg_prepare($db_connection, "my_query", 'SELECT * FROM cvsummary
      WHERE salaryrange > $1 AND salaryrange < $2
      AND age > $3 AND age < $4
      AND yearsofexperience > $5 AND yearsofexperience < $6
      AND leavetime > $7 AND leavetime < $8
      ORDER BY yearsofexperience DESC;');
   if(!$result){
      exit("query prepare error");
   }
   // Execute the prepared query.
   $result = pg_execute($db_connection, "my_query", array($minSalary, $maxSalary, $minAge, $maxAge, $minExp, $maxExp, $minLeave, $maxLeave));
   if(!$result){
      exit("query execute error");
   }


   $candIndex = 0;
   $allCandidates = array();

   if(!$result == false){
      while ($row = pg_fetch_row($result)){
         $allCandidates[$candIndex] = $row;
         $candIndex ++;
      }
   }
   $numOfCandidates = $candIndex;
   pg_free_result($result);



}
/* Closing connection */
pg_close($db_connection);
?>





<!DOCTYPE html>
<html>
<head>
   <title> Sök Kandidater </title>
   <link rel="stylesheet" type="text/css" href="searchstyle.css">
   <link rel="stylesheet" type="text/css" href="node_modules/semantic-ui-dropdown/dropdown.min.css">
   <link rel="stylesheet" type="text/css" href="node_modules/semantic-ui/dist/semantic.min.css">
   <link rel="stylesheet" type="text/css" href="range.css">
   <link rel="stylesheet" type="text/css" href="jquery-ui.min.css">

   <script src="jquery-3.2.1.min.js"></script>
   <script src="node_modules/semantic-ui/dist/components/transition.min.js"></script>
   <script src="node_modules/semantic-ui-dropdown/dropdown.min.js"></script>
   <script src="range.js"></script>
   <script src="slider.js"></script>
   <script src="jquery-ui.min.js"></script>
   <script src="node_modules/semantic-ui/dist/components/accordion.js"></script>
</head>

<body>
   <?php
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      echo "Keywords: ";
      for($i = 0; $i < sizeof($_POST['keywords']); $i++){
         echo $_POST['keywords'][$i] . "  ";
      }
      foreach ($_POST as $key => $value) {
         if($key == "keywords"){
            continue;
         }
         echo $key . ": ";
         echo $value;
         echo "\n";
      }
   }
   ?>

   <?php
   echo "\n\n";
   for($a = 0; $a < $numOfCandidates; $a ++){
      for($b = 0; $b < 16; $b ++){
         echo $allCandidates[$a][$b] . "  ";
      }
      echo "<br>";
   }
   ?>

      <div>
         <div>
            <h1 style="text-align:center; margin-top: 5%;"> Sök Kandidater </h1>
            <div>
               <form action="#" method="POST">
                  <div>
                     <div style="width:90%; margin:auto; margin-top: 5%;">
                       <p style="color:black; font-weight: bold; font-size =1.2em;">Kryssa i de tjänster som kan ha synonymer vid sortering av kandidater</p>
                        <div class="ui form">
                          <input type="checkbox" id="synonyms" name="synonyms" value="synonyms" class="synonyms" style="margin-left: 6.72542375%;">
                          <input type="checkbox" id="synonyms" name="synonyms" value="synonyms" class="synonyms" style="margin-left: 14.4508475%;">
                          <input type="checkbox" id="synonyms" name="synonyms" value="synonyms" class="synonyms" style="margin-left: 14.4508475%;">
                            <div class="four fields">
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Tidigare Tjänster</option>
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
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Tjänst Idag</option>
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
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Tjänst Viljes</option>
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
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Plats</option>
                                 <option value="STHLM">Stockholm</option>
                                 <option value="GBG">Göteborg</option>
                               </select>
                             </div>
                             <div class="required field" style="width:12.7321966%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                 <option value="">Ekonomisystem</option>
                                 <option value="BEK">Bästa ekonomi</option>
                                 <option value="UBEK">Underbar ekonomi</option>
                               </select>
                             </div>
                               <div class="required field" style="width:12.7321966%;">
                                 <select required multiple="" class="ui fluid search selection dropdown" name="keywords[]">
                                   <option value="">Utbildning</option>
                                   <option value="CIVEK">Civilekonom</option>
                                   <option value="EK">Ekonom</option>
                                 </select>
                               </div>

                             <div class="required field" style="width:12.7321966%;">
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
                           <h2>Lönenivå i SEK</h2>
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
                           <h2>Års Erfarenhet</h2>
                           <div class="ui segment" style="width:40%;">
                             <div class="ui range" id="range-7"></div>
                             <br>
                              <p>
                                Minimum: <span id="display-7"></span>
                              </p>
                              <div class="ui range" id="range-8"></div>
                              <br>
                               <p>
                                 Maximum: <span id="display-8"></span>
                               </p>
                           </div>
                           <h2>Uppsägningstid i månader</h2>
                           <div class="ui segment" style="width:40%;">
                             <div class="ui range" id="range-9"></div>
                             <br>
                              <p>
                                Minimum: <span id="display-9"></span>
                              </p>
                              <div class="ui range" id="range-10"></div>
                              <br>
                               <p>
                                 Maximum: <span id="display-10"></span>
                               </p>
                           </div>
                           <p>
                             <h2>Tillgänglighetsdatum</h2>
                             <label for="amount1" style = "margin-left: 0%;"></label>
                             <input type="text" name="amount1" id="amount1" style="border: 0; color: #f6931f; font-weight: bold; margin-left: 0%;" size="100" value"2018.01.01-2019.01.01"/>
                           </p>

                           <div id="slider-range1" style = "width:40%; margin: auto; float:left; margin-left: 0%;"></div>


                           <!-- Hidden inputs -->
                           <input type=hidden name="minsalary" id="minsalary" value="20000">
                           <input type=hidden name="maxsalary" id="maxsalary" value="100000">

                           <input type=hidden name="minage" id="minage" value="20">
                           <input type=hidden name="maxage" id="maxage" value="75">

                           <input type=hidden name="minexp" id="minexp" value="0">
                           <input type=hidden name="maxexp" id="maxexp" value="50">

                           <input type=hidden name="minleave" id="minleave" value="0">
                           <input type=hidden name="maxleave" id="maxleave" value="12">

                           <div class="field" style="width:20%; margin-top:5%;">
                              <button class="fluid ui button" type="submit">Sök efter kandidater</button>
                           </div>
                 </div>
              </form>
         </div>
      </div>
   </div>

<form style="margin-top:10%;">
   <h1 style="text-align: center;">Kandidater</h1>
<div id="notaccordion" class="Res">
  <div id="test">
  <label for="subscribeNews" style="color:black;">Kryssa i de kandidater du vill skicka notiser till</label>
  <label for="wishtitle" style="margin-left:25%; color:black;">Endast önskad titel</label>
  <input type="checkbox" id ="wishtitle" name = "wish">

  <!-- Sorteringsmeny -->
  <label for ="menu" style="color:black; margin-left:2.5%;">Sortering:</label>
  <div class="ui scrolling dropdown">
  <input type="hidden" name="gender">
  <div class="default text">Standard</div>
  <i class="dropdown icon"></i>
  <div class="menu">
    <div class="item">Erfarenhet (högst)</div>
    <div class="item">Erfarenhet (lägst)</div>
    <div class="item">Lönekrav (högst)</div>
    <div class="item">Lönekrav (lägst)</div>
    <div class="item">Rekommenderade (högst)</div>
    <div class="item">Rekommenderade (lägst)</div>
  </div>
  </div>
  </div>

   <!-- Beginning of loop  -->
   <?php
   for($candidate = 1; $candidate <= 15; $candidate++){
      echo '
        <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="text-align: right; float:right;">
        <h3 style="width:95%; margin-top:5px margin-right:0px !important;"><a href="#">';

        echo $candidate . ". " . "Joakim Olofsson / Personlig Assistent / Umeå";

        echo '</a></h3>
  <div style="width:95%; margin-top:5px;">
    <div class="Tryshiftright">
      <p>
        Dokument datum:
        <br>
        Högsta utbildnings nivå:
        <br>
        Antal års erfarenhet:
        <br>
        Nuvarande anställning:
        <br>
        Nuvarande anställare:
        <br>
        Tidigare tjänster:
        <br>
        Skills:
        <br>
        Ekonomisystem:
        <br>
        Språk:
        <br>
        Kandidat status:
        <br>
        Önskad titel:
        <br>
        Plats:
        <br>
        Lönenivå:
        <br>
        Ålder:
        <br>
        Uppsägningstid:
        <br>
        Tillgänglig tidigast:
        <br>
      </p>
    </div>
    <div class="Tryshiftleft">
      <p>
        2017-11-02
        <br>
        Kandidatexamen inom ekonomi, Umeå Universitet
        <br>
        6
        <br>
        Personlig Assistent
        <br>
        Umeå Kommun, Umeå
        <br>
        Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
        <br>
        Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning, Python
        <br>
        Bästa ekonomi
        <br>
        Svenska, Engelska Spanska, Franska
        <br>
        -
        <br>
        Controller
        <br>
        Umeå
        <br>
        100000
        <br>
        23
        <br>
        3 månader
        <br>
        -
        <br>
      </p>
    </div>
    <div class="SeeCV">
      <button class="ui right floated blue button">Se CV</button>
    </div>
  </div>';
  }
  echo
  '<div class = "pagnation">
    <div class="ui pagination menu">
      <a class="active item">
        1
      </a>
      <div class="disabled item">
        ...
      </div>
      <a class="item">
        10
      </a>
      <a class="item">
        11
      </a>
      <a class="item">
        12
      </a>
    </div>
   </div>';
?>
<!-- End of loop  -->
</div>
<div class="field" style="width:20%; margin-top:1%; margin-left:70.5%; color:#6497b1 !important;">
   <button class="fluid ui button" type="submit">Skicka notiser</button>
</div>
</form>

   <!--div class="contact">
     Kontakt
   </div-->

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
