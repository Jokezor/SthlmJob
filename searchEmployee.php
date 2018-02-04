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
                          <!--div class="inline fields">
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
                          </div-->
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
                           <!--h2>Tillgänglighets datum</h2>
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
                           <h2>Uppsägningstid i månader</h2>
                           <div class="ui segment" style="width:40%;">
                             <div class="ui range" id="range-11"></div>
                             <br>
                              <p>
                                Minimum: <span id="display-11"></span>
                              </p>
                              <div class="ui range" id="range-12"></div>
                              <br>
                               <p>
                                 Maximum: <span id="display-12"></span>
                               </p>
                           </div>
                           <p>
                             <h2>Tillgänglighets datum</h2>
                             <label for="amount1" style = "margin-left: 0%;"></label>
                             <input type="text" id="amount1" style="border: 0; color: #f6931f; font-weight: bold; margin-left: 0%;" size="100"/>
                           </p>

                           <div id="slider-range1" style = "width:40%; margin: auto; float:left; margin-left: 0%;"></div>

                           <!--div class="ui segment" style="width:12.7321966%;">
                             <div class="ui range" id="range-4"></div>
                             <br>
                              <p>
                                Maximum: <span id="display-4"></span>
                              </p>
                           </div-->
                           <div class="field" style="width:20%; margin-top:5%;">
                              <button class="fluid ui button" type="submit">Sök efter kandidater</button>
                           </div>
                 </div>
              </form>
             <!--div class ="Result" style="margin-top: 5%;">
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
            </div-->
         </div>
      </div>
   </div>

<form style="margin-top:10%;">
   <h1 style="text-align: center;">Kandidater</h1>
<div id="notaccordion" class="Res">
  <label for="subscribeNews" style="color:black;">Kryssa i de kandidater du vill skicka notiser till</label>
  <label for="wishtitle" style="margin-left:25%; color:black;">Endast önskad titel</label>
  <input type="checkbox" id ="wishtitle" name = "wish">
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
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="margin-top:20px;">
  <h3 style="width:95%; margin-top:5px"><a href="#">1.  Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">2. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">3. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">4. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="margin-top:20px;">
  <h3 style="width:95%; margin-top:5px"><a href="#">5. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">6. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">7. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">8. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="margin-top:20px;">
  <h3 style="width:95%; margin-top:5px"><a href="#">9. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">10. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">11. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">12. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees" style="margin-top:20px;">
  <h3 style="width:95%; margin-top:5px"><a href="#">13. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">14. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
  <input type="checkbox" id="subscribeNews" name="subscribe" value="newsletter" class="employees">
  <h3 style="width:95%; margin-top:5px"><a href="#">15. Joakim Olofsson / Personlig Assistent / Umeå</a></h3>
  <div style="width:95%; margin-top:5px;">
    <p class = "Rubrik">
    Dokument datum: 2017-11-02
    </p>
    <p>
    Högsta utbildnings nivå: Kandidatexamen inom ekonomi, Umeå Universitet
    <br>
    Antal års erfarenhet: 6
    <br>
    Nuvarande anställning: Personlig Assistent
    <br>
    Nuvarande anställare: Umeå Kommun, Umeå

    <br>
    Jobtitlar: Personlig assistent, Personlig Assistent, Vårdbiträde, praktik
    <br>
    Skills: Matlab, Programmering, C, Comsol Multiphysics, CAD, LaTeX, Officepaketet, Projektledning
    <br>
    Ekonomisystem: Bästa ekonomi
    <br>
    Språk: Svenska, Engelska Spanska, Franska
    <br>
    Kandidat status: -
    <br>
    Önskad titel: Controller
    <br>
    </p>
  </div>
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
