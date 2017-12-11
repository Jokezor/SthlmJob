<?php

   /* Array with names */
   $arr[] = "cto";
   $arr[] = "ceo";

   $wordfile = fopen("words_accepted.txt", "r") or die("Unable to open file!");


   /* get the q parameter from URL */
   $q = $_REQUEST["q"];

   $sugg[] = "";

   if ($q !== "") {
      $q = strtolower($q);
      $len=strlen($q);

      while(!feof($wordfile)) {
         $line = fgets($wordfile);
         $wordsInLine = explode(", ", $line);


         foreach($wordsInLine as $word){
            if(stristr($q, substr($word, 0, $len))){
               $sugg[] = $wordsInLine[0];
               break;
            }
         }
      }
   }

   /* Output "no suggestion" if no hint was found or output correct values */
   if($sugg === ""){
      echo "No suggestions\n";
   }
   else{
      echo "<MATCHINGWORDS>";
      for($i = 0; $i < count($sugg); $i++){
         echo "<WORD> " . $sugg[$i] . " </WORD>";
      }
      echo "</MATCHINGWORDS>";
   }
   fclose($wordfile);
?>
