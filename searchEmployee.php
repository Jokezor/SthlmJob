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

    // CV summary table
    // Prepare a query for execution
   $cvsummaryResult = pg_prepare($db_connection, "my_query1", ' SELECT userid, cvtitle, yearsofexperience, currentposition, currentemployer, last3experiences, highesteducationlevel, salaryrange, age, leavetime, candidatestatus, availability
      FROM cvsummary
      WHERE salaryrange > $1 AND salaryrange < $2
      AND age > $3 AND age < $4
      AND yearsofexperience > $5 AND yearsofexperience < $6
      AND leavetime > $7 AND leavetime < $8
      ORDER BY yearsofexperience DESC;');
   if(!$cvsummaryResult){
      exit("query prepare error");
   }
   // Execute the prepared query.
   $cvsummaryResult = pg_execute($db_connection, "my_query1", array($minSalary, $maxSalary, $minAge, $maxAge, $minExp, $maxExp, $minLeave, $maxLeave));
   if(!$cvsummaryResult){
      exit("query execute error");
   }
   // ----------------
   if(pg_num_rows($cvsummaryResult) != 0){
      $candIndex = 0;
      $allCandidates = array(array());
      $allUserids = array();
      if(!$cvsummaryResult == false){
         while ($row = pg_fetch_row($cvsummaryResult)){
            $userid = $row[0];
            $allUserids[$candIndex] = $userid;
            $allCandidates[$userid]["userid"] = $row[0];
            $allCandidates[$userid]["cvtitle"] = $row[1];
            $allCandidates[$userid]["yearsofexperience"] = $row[2];
            $allCandidates[$userid]["currentposition"] = $row[3];
            $allCandidates[$userid]["currentemployer"] = $row[4];
            $allCandidates[$userid]["last3experiences"] = $row[5];
            $allCandidates[$userid]["highesteducationlevel"] = $row[6];
            $allCandidates[$userid]["salaryrange"] = $row[7];
            $allCandidates[$userid]["age"] = $row[8];
            $allCandidates[$userid]["leavetime"] = $row[9];
            $allCandidates[$userid]["candidatestatus"] = $row[10];
            $allCandidates[$userid]["availability"] = $row[11];
            $candIndex ++;
         }
      }
      $numOfCandidates = $candIndex;

      $pgsqlstr = implode(', ', $allUserids);
      if(strlen($pgsqlstr != 0)){
         $itSkillsResult = pg_query($db_connection, ' SELECT userid, itskill
            FROM itskills WHERE userid IN (' . $pgsqlstr . ');');
         if(!$itSkillsResult){
            exit("query error");
         }
         $languageSkillsResult = pg_query($db_connection, ' SELECT userid, lang
            FROM languageskills WHERE userid IN (' . $pgsqlstr . ');');
         if(!$languageSkillsResult){
            exit("query error");
         }
         $personResult = pg_query($db_connection, ' SELECT userid, firstname, lastname, city
            FROM person WHERE userid IN (' . $pgsqlstr . ');');
         if(!$personResult){
            exit("query error");
         }
         $businessSkillsResult = pg_query($db_connection, ' SELECT userid, businessskill
            FROM businessskills WHERE userid IN (' . $pgsqlstr . ');');
         if(!$businessSkillsResult){
            exit("query error");
         }
      }

      if(!$itSkillsResult == false){
         while ($row = pg_fetch_row($itSkillsResult)){
            $userid = $row[0];   $skill = $row[1];
            //$allCandidates[$userid]["itskills"] = $allCandidates[$userid]["itskills"] . ", " . $skill;
            $allCandidates[$userid]["itskills"][] = $skill;
         }
         pg_free_result($itSkillsResult);
      }

      if(!$languageSkillsResult == false){
         while ($row = pg_fetch_row($languageSkillsResult)){
            $userid = $row[0];   $skill = $row[1];
            //$allCandidates[$userid]["langskills"] = $allCandidates[$userid]["langskills"] . ", " . $skill;
            $allCandidates[$userid]["langskills"][] = $skill;
         }
         pg_free_result($languageSkillsResult);
      }

      if(!$personResult == false){
         while ($row = pg_fetch_row($personResult)){
            $userid = $row[0];   $name = $row[1] . " " . $row[2];   $city = $row[3];
            $allCandidates[$userid]["name"] = $name;
            $allCandidates[$userid]["city"] = $city;
         }
         pg_free_result($personResult);
      }

      if(!$businessSkillsResult == false){
         while ($row = pg_fetch_row($businessSkillsResult)){
            $userid = $row[0];   $businessSkill = $row[1];
            //$allCandidates[$userid]["businessskills"] = $allCandidates[$userid]["businessskills"] . ", " . $businessSkill;
            $allCandidates[$userid]["businessskills"][] = $businessSkill;
         }
         pg_free_result($businessSkillsResult);
      }
      $keywords = array(
         $_POST['keywords0'], $_POST['keywords1'],
         $_POST['keywords2'], $_POST['keywords3'],
         $_POST['keywords4'], $_POST['keywords5'], $_POST['keywords6']
      );
      calculateScore($allCandidates, $keywords);
   }
   else{
      echo "INGA KANDIDATER :(";
   }

}
/* Closing connection */
pg_close($db_connection);
function calculateScore($allCandidates, $keywords){
   $weights = array(25,20,15,12,10,9,9);
   foreach ($allCandidates as $cand) {
      // last3experiences

      //currentposition

      // Position wanted

      // city

      // Ekonimisystem
      $numOfAgree = 0;
      $searchedFor = $keywords[4];
      if(array_key_exists("businessskills", $cand)){
         //$businessArray = explode(', ', $cand["businessskills"]);
         $businessArray = $cand["businessskills"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($businessArray); $j++){
               if(!strcmp($searchedFor[$i], $businessArray[$j])){
                  $numOfAgree++;
               }

               echo $businessArray[$j] . "  ";
               echo $searchedFor[$i] . '\\';
            }
         }
      }

      $businessScore = $numOfAgree/sizeof($searchedFor)*$weights[4];
      echo "businessScore: " . $businessScore;
      // education

      // Itskills

      $numOfAgree = 0;
      $searchedFor = $keywords[6];
      if(array_key_exists("itskills", $cand)){
         $itskillsArray = $cand["itskills"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($itskillsArray); $j++){
               if(!strcmp($searchedFor[$i], $itskillsArray[$j])){
                  $numOfAgree++;
               }

               echo $itskillsArray[$j] . "  ";
               echo $searchedFor[$i] . '\\';
            }
         }
      }

      $itScore = $numOfAgree/sizeof($searchedFor)*$weights[6];
      echo "Itscore: " . $itScore;
      echo "Total score: " . $itScore; // + ...
      echo "<br>";
      echo "<br>";

   }
}
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

   <!--  Printing out for errorchecking -->
   <?php
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      echo "Keywords: ";
      for($i = 0; $i < sizeof($_POST['keywords0']); $i++){
         echo $_POST['keywords0'][$i] . "  ";
      }
      foreach ($_POST as $key => $value) {
         if($key == "keywords0"){
            continue;
         }
         echo $key . ": ";
         //echo $value;
         echo "\n";
      }
   }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(pg_num_rows($cvsummaryResult) != 0){
         // Comparison function
         function cmp($cand1, $cand2) {
            if ($cand1["age"] == $cand2["age"]) {
               return 0;
            }
            if($cand1["age"] > $cand2["age"]){
               return -1;
            }
            else {
               return 1;
            }
         }
         //bool uasort ( array &$array , callable $value_compare_func )
         if(!uasort($allCandidates, 'cmp')){
            echo "sort error";
         }
      }


      if($_SERVER["REQUEST_METHOD"] == "POST"){
         foreach ($allCandidates as $cand) {
            foreach ($cand as $column => $value) {
               //echo $column . ": " . $value . "\t\t";
               echo $column . ": ";
               print_r($value);
            }
            echo "<br>";
         }
      }
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
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords0[]">
                                 <option value="">Tidigare Tjänster</option>
                                 <option value="Controller">Controller</option>
                                 <option value="Styrekonom">Styrekonom</option>
                                 <option value="Ekonomichef">Ekonomichef</option>
                                 <option value="Ekonomiövervakare">Ekonomiövervakare</option>
                                 <option value="Kamrer">Kamrer</option>
                                 <option value="Bokhållare">Bokhållare</option>
                                 <option value="Ekonomiassistent">Ekonomiassistent</option>
                                 <option value="Räkenskapsförare">Räkenskapsförare</option>
                                 <option value="Redovisningsekonom">Redovisningsekonom</option>
                                 <option value="Redovisningsansvarig">Redovisningsansvarig</option>
                                 <option value="Redovisningsekonom">Redovisningsekonom</option>
                                 <option value="Redovisningschef">Redovisningschef</option>
                                 <option value="Chief Financial Officer">Chief Financial Officer</option>
                                 <option value="Business Controller">Business Controller</option>
                                 <option value="Financial Controller">Financial Controller</option>
                                 <option value="Koncernredovisningsekonom">Koncernredovisningsekonom</option>
                                 <option value="Koncernredovisningschef">Koncernredovisningschef</option>
                                 <option value="Verkställande Direktör">Verkställande Direktör</option>
                                 <option value="VD">VD</option>
                                 <option value="CEO">CEO</option>
                                 <option value="Direktör">Direktör</option>
                                 <option value="Chef">Chef</option>
                                 <option value="Föreståndare">Föreståndare</option>
                               </select>
                             </div>
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords1[]">
                                 <option value="">Tjänst Idag</option>
                                 <option value="Controller">Controller</option>
                                 <option value="Styrekonom">Styrekonom</option>
                                 <option value="Ekonomichef">Ekonomichef</option>
                                 <option value="Ekonomiövervakare">Ekonomiövervakare</option>
                                 <option value="Kamrer">Kamrer</option>
                                 <option value="Bokhållare">Bokhållare</option>
                                 <option value="Ekonomiassistent">Ekonomiassistent</option>
                                 <option value="Räkenskapsförare">Räkenskapsförare</option>
                                 <option value="Redovisningsekonom">Redovisningsekonom</option>
                                 <option value="Redovisningsansvarig">Redovisningsansvarig</option>
                                 <option value="Redovisningsekonom">Redovisningsekonom</option>
                                 <option value="Redovisningschef">Redovisningschef</option>
                                 <option value="Chief Financial Officer">Chief Financial Officer</option>
                                 <option value="Business Controller">Business Controller</option>
                                 <option value="Financial Controller">Financial Controller</option>
                                 <option value="Koncernredovisningsekonom">Koncernredovisningsekonom</option>
                                 <option value="Koncernredovisningschef">Koncernredovisningschef</option>
                                 <option value="Verkställande Direktör">Verkställande Direktör</option>
                                 <option value="VD">VD</option>
                                 <option value="CEO">CEO</option>
                                 <option value="Direktör">Direktör</option>
                                 <option value="Chef">Chef</option>
                                 <option value="Föreståndare">Föreståndare</option>
                               </select>
                             </div>
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords2[]">
                                 <option value="">Tjänst Viljes</option>
                                 <option value="Controller">Controller</option>
                                 <option value="Styrekonom">Styrekonom</option>
                                 <option value="Ekonomichef">Ekonomichef</option>
                                 <option value="Ekonomiövervakare">Ekonomiövervakare</option>
                                 <option value="Kamrer">Kamrer</option>
                                 <option value="Bokhållare">Bokhållare</option>
                                 <option value="Ekonomiassistent">Ekonomiassistent</option>
                                 <option value="Räkenskapsförare">Räkenskapsförare</option>
                                 <option value="Redovisningsekonom">Redovisningsekonom</option>
                                 <option value="Redovisningsansvarig">Redovisningsansvarig</option>
                                 <option value="Redovisningsekonom">Redovisningsekonom</option>
                                 <option value="Redovisningschef">Redovisningschef</option>
                                 <option value="Chief Financial Officer">Chief Financial Officer</option>
                                 <option value="Business Controller">Business Controller</option>
                                 <option value="Financial Controller">Financial Controller</option>
                                 <option value="Koncernredovisningsekonom">Koncernredovisningsekonom</option>
                                 <option value="Koncernredovisningschef">Koncernredovisningschef</option>
                                 <option value="Verkställande Direktör">Verkställande Direktör</option>
                                 <option value="VD">VD</option>
                                 <option value="CEO">CEO</option>
                                 <option value="Direktör">Direktör</option>
                                 <option value="Chef">Chef</option>
                                 <option value="Föreståndare">Föreståndare</option>
                               </select>
                             </div>
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords3[]">
                                 <option value="">Plats</option>
                                 <option value="Stockholm">Stockholm</option>
                                 <option value="Göteborg">Göteborg</option>
                               </select>
                             </div>
                             <div class="required field" style="width:12.7321966%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords4[]">
                                 <option value="">Ekonomisystem</option>
                                 <option value="Bästa ekonomi">Bästa ekonomi</option>
                                 <option value="Underbar ekonomi">Underbar ekonomi</option>
                               </select>
                             </div>
                               <div class="required field" style="width:12.7321966%;">
                                 <select required multiple="" class="ui fluid search selection dropdown" name="keywords5[]">
                                   <option value="">Utbildning</option>
                                   <option value="Civilekonom">Civilekonom</option>
                                   <option value="Ekonom">Ekonom</option>
                                 </select>
                               </div>

                             <div class="required field" style="width:12.7321966%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords6[]">
                                 <option value="">Skills</option>
                                 <option value="Programmering">Programmering</option>
                                 <option value="C">C</option>
                                 <option value="C#">C#</option>
                                 <option value="C++">C++</option>
                                 <option value="Python">Python</option>
                                 <option value="Excel">Excel</option>
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

                           <h2>Erfarenhet i roll</h2>
                           <label for="amount2" style = "margin-left: 0%;"></label>
                           <input type="text" name="amount2" id="amount2" style="border: 0; color: #f6931f; font-weight: bold; margin-left: 0%;" size="100" value"0-50"/>
                         </p>

                         <div id="slider-range2" style = "width:40%; margin: auto; float:left; margin-left: 0%;"></div>



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
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      if(pg_num_rows($cvsummaryResult) != 0){
         $candNumber = 1;
         foreach($allCandidates as $candidate){
            if(!empty($candidate)){
               echo '
                 <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="text-align: right; float:right;">
                 <h3 style="width:95%; margin-top:5px margin-right:0px !important;"><a href="#">';

                 echo $candNumber . ". " . $candidate["name"] . "/ " . $candidate["currentposition"] . " /" . $candidate["city"];

                 echo '</a></h3>
           <div style="width:95%; margin-top:5px;">
             <div class="Tryshiftright">
               <p>
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
                 ' . $candidate["highesteducationlevel"] . '
                 <br>
                 ' . $candidate["yearsofexperience"] . '
                 <br>
                 ' . $candidate["currentposition"] . '
                 <br>
                 ' . $candidate["currentemployer"] . ', ' . $candidate["city"] . '
                 <br>
                 ' . $candidate["last3experiences"] . '
                 <br>
                 ' . ((array_key_exists("itskills", $candidate)) ? $candidate["itskills"] : "-") . '
                 <br>
                 -
                 <br>
                 ' . ((array_key_exists("langskills", $candidate)) ? $candidate["langskills"] : "-") . '
                 <br>
                 ' . $candidate["candidatestatus"] . '
                 <br>
                 ?
                 <br>
                 ' . $candidate["city"] . '
                 <br>
                 ' . $candidate["salaryrange"] . '
                 <br>
                 ' . $candidate["age"] . '
                 <br>
                 ' . $candidate["leavetime"] . '
                 <br>
                 ' . $candidate["availability"] . '
                 <br>
               </p>
             </div>
             <div class="SeeCV">
               <button class="ui right floated blue button">Se CV</button>
             </div>
           </div>';
            $candNumber ++;
            }
         }
         pg_free_result($cvsummaryResult);
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
   }
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
