<?php include "../inc/dbinfo.inc";?>
<?php
  /* Connect to PostGreSQL and select the database. */

  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());

?>

<?php
 /* If input fields are populated, add a row to the Users table. */
 if($_SERVER["REQUEST_METHOD"] == "POST"){

   $keywords = array(
      $_POST['keywords0'], $_POST['keywords1'],
      $_POST['keywords2'], $_POST['keywords3'],
      $_POST['keywords4'], $_POST['keywords5']
   );
   $jobWanted = $keywords[0];

   $minSalary = htmlentities($_POST['minsalary']);
   $maxSalary = htmlentities($_POST['maxsalary']);
   $minAge = htmlentities($_POST['minage']);
   $maxAge = htmlentities($_POST['maxage']);
   $minExp = htmlentities($_POST['minexp']);
   $maxExp = htmlentities($_POST['maxexp']);
   $minLeave = htmlentities($_POST['minleave']);
   $maxLeave = htmlentities($_POST['maxleave']);

   $sortingOut = array(
     $minSalary, $maxSalary, $minAge, $maxAge,
     $minExp, $maxExp, $minLeave, $maxLeave
   );

   // CV summary table
   // Prepare a query for execution
  $PreferencesResult = pg_prepare($db_connection, "my_query2", ' SELECT userid, job, branch
     FROM preferences
     WHERE job = $1;');
  if(!$PreferencesResult){
     exit("query prepare error");
  }
  // Execute the prepared query.
  $PreferencesResult = pg_execute($db_connection, "my_query2", array($jobWanted[0]));
  if(!$PreferencesResult){
     exit("query execute error");
  }

   // ----------------

  // ----------------
      if(pg_num_rows($PreferencesResult) != 0){
        $candIndex = 0;
        $allCandidates = array(array());
        $allUserids = array();
        if(!$PreferencesResult == false){
           while ($ro = pg_fetch_row($PreferencesResult)){
             $usid = $ro[0];
             $allUserids[$candIndex] = $usid;
             $allCandidates[$usid]["userid"] = $ro[0];
             $allCandidates[$usid]["job"] = $ro[1];
             $allCandidates[$usid]["branch"][] = $ro[2];
             $candIndex ++;
           }
         }

       // CV summary table
       // Prepare a query for execution
       $pgsqlstr = implode(', ', $allUserids);

       $cvsummaryResult = pg_query($db_connection, ' SELECT userid, cvtitle, yearsofexperience, currentposition, currentemployer, last3experiences, highesteducationlevel, salaryrange, age, leavetime, candidatestatus, availability
         FROM cvsummary
         WHERE userid IN (' . $pgsqlstr . ');');
      if(!$cvsummaryResult){
         exit("query prepare error");
      }

       $numOfCandidates = $candIndex;
       $i=0;
      if(!$cvsummaryResult == false){
         while ($row = pg_fetch_row($cvsummaryResult)){
            $userid = $allUserids[$i];
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
            $i++;
         }
      }

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
         $personResult = pg_query($db_connection, ' SELECT userid, firstname, lastname, title, nationality, birthdate, salutation, driverslicense, telephonenumber, mobilenumber, email, streetname, postcode, city, region, country, url
            FROM person WHERE userid IN (' . $pgsqlstr . ');');
         if(!$personResult){
            exit("query error");
         }
         $businessSkillsResult = pg_query($db_connection, ' SELECT userid, businessskill
            FROM businessskills WHERE userid IN (' . $pgsqlstr . ');');
         if(!$businessSkillsResult){
            exit("query error");
         }
         $softSkillsResult = pg_query($db_connection, ' SELECT userid, skill
            FROM softskills WHERE userid IN (' . $pgsqlstr . ');');
         if(!$softSkillsResult){
            exit("query error");
         }
         $workexperienceResult = pg_query($db_connection, ' SELECT userid, positiontitle, employer, startdate, enddate
            FROM workexperience WHERE userid IN (' . $pgsqlstr . ');');
         if(!$workexperienceResult){
            exit("query error");
         }
         $educationResult = pg_query($db_connection, ' SELECT userid, educationname, diplomaobtained, nameofinstitution, degreedirection, gradepointaverage, startdate, enddate
            FROM education WHERE userid IN (' . $pgsqlstr . ');');
         if(!$educationResult){
            exit("query error");
         }
         /*$hobbiesResult = pg_query($db_connection, ' SELECT userid, skill
            FROM hobbies WHERE userid IN (' . $pgsqlstr . ');');
         if(!$softSkillsResult){
            exit("query error");
         }
         */
      }

      if(!$itSkillsResult == false){
         while ($row = pg_fetch_row($itSkillsResult)){
            $userid = $row[0];
            $skill = $row[1];
            //$allCandidates[$userid]["itskills"] = $allCandidates[$userid]["itskills"] . ", " . $skill;
            $allCandidates[$userid]["itskills"][] = $skill;
         }
         pg_free_result($itSkillsResult);
      }

      if(!$softSkillsResult == false){
         while ($row = pg_fetch_row($softSkillsResult)){
            $userid = $row[0];
            $skill = $row[1];
            //$allCandidates[$userid]["itskills"] = $allCandidates[$userid]["itskills"] . ", " . $skill;
            $allCandidates[$userid]["softskills"][] = $skill;
         }
         pg_free_result($softSkillsResult);
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
            $userid = $row[0];   $name = $row[1] . " " . $row[2];   $city = $row[13];
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

      if(!$workexperienceResult == false){
         while ($row = pg_fetch_row($workexperienceResult)){
            $userid = $row[0];   $positiontitle = $row[1]; $employer = $row[2]; $startdate = $row[3]; $enddate = $row[4];
            # Kommer vara vektorer.
            $allCandidates[$userid]["positions"][] = $positiontitle;
            $allCandidates[$userid]["employers"][] = $employer;
            $allCandidates[$userid]["workstartdates"][] = $startdate;
            $allCandidates[$userid]["workenddates"][] = $enddate;
         }
         pg_free_result($workexperienceResult);
      }

      if(!$educationResult == false){
         while ($row = pg_fetch_row($educationResult)){
            $userid = $row[0];   $educationname = $row[1]; $diplomaobtained = $row[2]; $nameofinstitution = $row[3]; $degreedirection = $row[4];
            $gradepointaverage = $row[5]; $startdate = $row[6]; $enddate = $row[7];
            # Kommer vara vektorer.
            $allCandidates[$userid]["educationnames"][] = $educationname;
            $allCandidates[$userid]["diplomasobtained"][] = $diplomaobtained;
            $allCandidates[$userid]["nameofinstitutions"][] = $nameofinstitution;
            $allCandidates[$userid]["degreedirections"][] = $degreedirection;
            $allCandidates[$userid]["gradepointaverages"][] = $gradepointaverage;
            $allCandidates[$userid]["educationstartdates"][] = $startdate;
            $allCandidates[$userid]["educationenddates"][] = $enddate;
         }
         pg_free_result($educationResult);
      }

      calculateScore($allCandidates, $keywords, $sortingOut);
   }
   else{
      echo "INGA KANDIDATER :(";
   }
}
/* Closing connection */
pg_close($db_connection);
function calculateScore($allCandidates, $keywords, $sortingOut){
   $weights = array(22,17,15,14,14,10,8);
   $index = 0;
   $sortInsearched = array();
   foreach ($allCandidates as $cand) {
     if($cand != null){

      // branch
      $searchedFor = $keywords[1];
      $branchScore=0;
      if(array_key_exists("branch", $cand)){
         $branchArray = $cand["branch"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($branchArray); $j++){
               if(!strcmp($searchedFor[$i], $branchArray[$j])){
                  $branchScore=$weights[0];
               }

               #echo $branchArray[$j] . "  ";
               #echo $searchedFor[$i] . '\\';
            }
         }
      }

      echo "branchScore: " . $branchScore;


      // currentposition
      $searchedFor = $keywords[0];
      $currentpositionScore=0;
      if(array_key_exists("currentposition", $cand)){
         $currenpositionArray = $cand["currentposition"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($currenpositionArray); $j++){
               if(!strcmp($searchedFor[$i], $currenpositionArray[$j])){
                  $currentpositionScore=$weights[1];
               }

               #echo $branchArray[$j] . "  ";
               #echo $searchedFor[$i] . '\\';
            }
         }
      }

      echo "currentpositionScore: " . $currentpositionScore;


      // Ekonimisystem
      $numOfAgreebusiness = 0;
      $searchedFor = $keywords[4];
      if(array_key_exists("businessskills", $cand)){
         //$businessArray = explode(', ', $cand["businessskills"]);
         $businessArray = $cand["businessskills"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($businessArray); $j++){
               if(!strcmp($searchedFor[$i], $businessArray[$j])){
                  $numOfAgreebusiness++;
               }

               //echo $businessArray[$j] . "  ";
               //echo $searchedFor[$i] . '\\';
            }
         }
      }
      $Amountsearchedforbusiness = sizeof($searchedFor);


      // Itskills
      $numOfAgreeitskills = 0;
      $searchedFor = $keywords[4];
      if(array_key_exists("itskills", $cand)){
         $itskillsArray = $cand["itskills"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($itskillsArray); $j++){
               if(!strcmp($searchedFor[$i], $itskillsArray[$j])){
                  $numOfAgreeitskills++;
               }

               //echo $itskillsArray[$j] . "  ";
               //echo $searchedFor[$i] . '\\';
            }
         }
      }


      // Softskills
      $numOfAgreesoftskills = 0;
      $searchedFor = $keywords[4];
      if(array_key_exists("softskills", $cand)){
         $softskillsArray = $cand["softskills"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($softskillsArray); $j++){
               if(!strcmp($searchedFor[$i], $softskillsArray[$j])){
                  $numOfAgreesoftskills++;
               }

               //echo $softskillsArray[$j] . "  ";
               //echo $searchedFor[$i] . '\\';
            }
         }
      }

      // Languages
      $numOfAgreelanguages = 0;
      $searchedFor = $keywords[4];
      if(array_key_exists("langskills", $cand)){
         $languagesArray = $cand["langskills"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($languagesArray); $j++){
               if(!strcmp($searchedFor[$i], $languagesArray[$j])){
                  $numOfAgreelanguages++;
               }

               //echo $languagesArray[$j] . "  ";
               //echo $searchedFor[$i] . '\\';
            }
         }
      }

      // Geografi
      $searchedFor = $keywords[3];
      $geographyScore=0;
      if(array_key_exists("city", $cand)){
         $geographyArray = $cand["city"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($geographyArray); $j++){
               if(!strcmp($searchedFor[$i], $geographyArray[$j])){
                  $geographyScore=$weights[6];
               }

               #echo $branchArray[$j] . "  ";
               #echo $searchedFor[$i] . '\\';
            }
         }
      }

      echo "geographyScore: " . $geographyScore;


      // Tidigare Roller
      $numOfAgreejobs = 0;
      $searchedFor = $keywords[2];
      if(array_key_exists("positions", $cand)){
         $earlyjobsArray = $cand["positions"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($earlyjobsArray); $j++){
               if(!strcmp($searchedFor[$i], $earlyjobsArray[$j])){
                  $numOfAgreejobs++;
               }

               //echo $languagesArray[$j] . "  ";
               //echo $searchedFor[$i] . '\\';
            }
         }
      }
      $earlyJobsScore = ($numOfAgreejobs/sizeof($searchedFor))*$weights[3];


      // Erfarenhet inom roll man söker
      $searchedFor = $keywords[0];
      $experienceinsearched=0;
      if(array_key_exists("positions", $cand)){
         $positionsArray = $cand["positions"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($positionsArray); $j++){
               if(!strcmp($searchedFor[$i], $positionsArray[$j])){
                  $startdate = strtotime($cand["workstartdates"][$j]);
                  $enddate = strtotime($cand["workenddates"][$j]);
                  $datediff = ($enddate-$startdate);
                  $experienceinsearched=$experienceinsearched + round($datediff / (60 * 60 * 24));
               }
            }
         }
      }
      echo "experienceinsearched: " . $experienceinsearched;

      // Erfarenhet inom nuvarande roll
      $experienceincurrent=0;
      if(array_key_exists("currentposition", $cand)){
         $currenpositionArray = $cand["currentposition"];
         $positionsArray = $cand["positions"];

         for($i = 0; $i < sizeof($positionsArray); $i++){
            for($j = 0; $j < sizeof($currenpositionArray); $j++){
               if(!strcmp($positionsArray[$i], $currenpositionArray[$j])){
                 $startdate = strtotime($cand["workstartdates"][j]);
                 $enddate = strtotime($cand["workenddates"][j]);
                 $datediff = ($enddate-$startdate);
                 $experienceincurrent=$experienceincurrent + round($datediff / (60 * 60 * 24));
               }
            }
         }
      }

      echo "experienceincurrent: " . $experienceincurrent;




      // Utbildning
      $searchedFor = $keywords[5];
      $educationScore=0;
      if(array_key_exists("educationname", $cand)){
         $educationArray = $cand["educationname"];

         for($i = 0; $i < sizeof($searchedFor); $i++){
            for($j = 0; $j < sizeof($educationArray); $j++){
               if(!strcmp($searchedFor[$i], $educationArray[$j])){
                  $educationScore=$weights[5];
               }

               #echo $branchArray[$j] . "  ";
               #echo $searchedFor[$i] . '\\';
            }
         }
      }
      // Calculate the median later to be used to give those above the median score.


      $sortInsearched[] = [$experienceinsearched,$cand["userid"]];
      $allCandidates[$cand["userid"]]["experienceincurrent"] = $experienceincurrent;
      $allCandidates[$cand["userid"]]["experienceinsearched"] = $experienceinsearched;

      $freetextScore = ($numOfAgreeitskills + $numOfAgreebusiness + $numOfAgreesoftskills + $numOfAgreelanguages)/($Amountsearchedforbusiness);
      $freetextScore=$freetextScore*$weights[2];

      $totalScore = $currentpositionScore + $branchScore + $freetextScore + $geographyScore + $educationScore + $earlyJobsScore;

      $allCandidates[$cand["userid"]]["score"] = $totalScore;
      echo "Total score: " . $allCandidates[$cand["userid"]]["score"]; // + ...
      echo "<br>";
      echo "<br>";
      $index++;
    }
   }

   // Sortera kandidater här.
   //print_r($sortIncurrent);
   rsort($sortInsearched);
   $N=sizeof($sortInsearched);
   $median=$sortInsearched[floor($N/2)][0];
   echo "median: " . floor($N/2);


   foreach ($sortInsearched as $exp => $value) {
     if($value[0] != null){
       if($allCandidates[$value[1]]["experienceinsearched"] >= $median){
         $allCandidates[$value[1]]["score"] = $allCandidates[$value[1]]["score"] + $weights[4];
       }
     }
     echo "Heres candidate score" . $allCandidates[$value[1]]["score"];
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
   <meta name="viewport" content="width=device-width, initial-scale=1">
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
                       <p style="color:black; font-weight: bold; font-size =1.2em;">I detta sökverktyg fyller ni i vad ni söker och så rangordnar vi kandidater åt er</p>
                       <br>
                        <div class="ui form">
                          <!--input type="checkbox" id="synonyms" name="synonyms" value="synonyms" class="synonyms" style="margin-left: 6.72542375%;">
                          <input type="checkbox" id="synonyms" name="synonyms" value="synonyms" class="synonyms" style="margin-left: 14.4508475%;">
                          <input type="checkbox" id="synonyms" name="synonyms" value="synonyms" class="synonyms" style="margin-left: 14.4508475%;"-->
                            <div class="four fields">
                             <div class="required field" style="width:15.4508475%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords0[]">
                                 <option value="">Tjänst Sökes</option>
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
                                 <option value="">Bransch</option>
                                 <option value="Business">Business</option>
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
                                 <option value="">Tidigare Roller</option>
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
                             <div class="required field" style="width:19.098295%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords4[]">
                                 <option value="">Fritext</option>
                                 <option value="Bästa ekonomi">Bästa ekonomi</option>
                                 <option value="Underbar ekonomi">Underbar ekonomi</option>
                                 <option value="Programmering">Programmering</option>
                                 <option value="C">C</option>
                                 <option value="C#">C#</option>
                                 <option value="C++">C++</option>
                                 <option value="Python">Python</option>
                                 <option value="Excel">Excel</option>
                               </select>
                             </div>
                               <div class="required field" style="width:19.098295%;">
                                 <select required multiple="" class="ui fluid search selection dropdown" name="keywords5[]">
                                   <option value="">Utbildning</option>
                                   <option value="Civilekonom">Civilekonom</option>
                                   <option value="Ekonom">Ekonom</option>
                                 </select>
                               </div>
                             <!--div class="required field" style="width:12.7321966%;">
                               <select required multiple="" class="ui fluid search selection dropdown" name="keywords6[]">
                                 <option value="">Skills</option>
                                 <option value="Programmering">Programmering</option>
                                 <option value="C">C</option>
                                 <option value="C#">C#</option>
                                 <option value="C++">C++</option>
                                 <option value="Python">Python</option>
                                 <option value="Excel">Excel</option>
                               </select>
                             </div-->
                           </div>
                           <!--div class="ui sub header" style="width:15.4508475%!important; max-width: 15.4508475%!important;">Urval</div>
                            <div class="required field" style="width:15.4508475%;">
                             <div class="ui fluid multiple search special selection dropdown" style ="overflow: visible;">
                             <i class="dropdown icon"></i>
                             <div class="menu">
                              <div class="item" style="width:100%; margin-bottom:5%;">
                                <h2 style ="text-align: left !important; font-size: 100%;">Erfarenhet i roll</h2>
                                <label for="amount2" style = "margin-left: 0%;"></label>
                                <input type="text" name="amount2" id="amount2" style="border: 0; color: #f6931f; font-weight: bold; margin-left: 0%;" size="100" value"0-50"/>
                              </p>

                                <div id="slider-range2" style = "width:100%; margin: auto; float:left; margin-left: 0%;"></div>
                              </div>
                              <div class="item">
                                <span class="description">ctrl + o</span>
                                Open...
                              </div>
                              <div class="item">
                                <span class="description">ctrl + s</span>
                                Save as...
                              </div>
                            </div>
                          </div>
                        </div-->
                           <br>
                           <br>
                           <br>
                           <br>
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
                           <!--h2>Uppsägningstid i månader</h2>
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
                           </div-->
                           <!--h2>Erfarenhet i rollen som sökes</h2>
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
                           </div-->
                           <!--p>
                             <h2>Tillgänglighetsdatum</h2>
                             <label for="amount1" style = "margin-left: 0%;"></label>
                             <input type="text" name="amount1" id="amount1" style="border: 0; color: #f6931f; font-weight: bold; margin-left: 0%;" size="100" value"2018.01.01-2019.01.01"/>
                           </p>

                           <div id="slider-range1" style = "width:40%; margin: auto; float:left; margin-left: 0%;"></div-->
                           <!--p>
                             <br>
                             <h2 style ="text-align: left !important;">Erfarenhet i roll</h2>
                             <label for="amount2" style = "margin-left: 0%;"></label>
                             <input type="text" name="amount2" id="amount2" style="border: 0; color: #f6931f; font-weight: bold; margin-left: 0%;" size="100" value"0-50"/>
                           </p>

                         <div id="slider-range2" style = "width:15.4508475%; margin: auto; float:left; margin-left: 0%;"></div-->



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
  <label for="subscribeNews" style="color:black;">Ta kontakta med de kandidater som matchar via mail</label>
  <!--label for="wishtitle" style="margin-left:25%; color:black;">Endast önskad titel</label>
  <input type="checkbox" id ="wishtitle" name = "wish"-->

  <!-- Sorteringsmeny -->
  <!--label for ="menu" style="color:black; margin-left:2.5%;">Sortering:</label>
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
</div-->

   <!-- Beginning of loop  -->

   <?php
   if($_SERVER["REQUEST_METHOD"] == "POST"){
      if(pg_num_rows($cvsummaryResult) != 0){
         $candNumber = 1;
         foreach($allCandidates as $candidate){
            if(!empty($candidate)){
               echo '
                 <!--input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="text-align: right; float:right;"-->
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
                 Email:
                 <br>
                 Mobil:
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
<!--div class="field" style="width:20%; margin-top:1%; margin-left:70.5%; color:#6497b1 !important;">
   <button class="fluid ui button" type="submit">Skicka notiser</button>
</div-->
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
