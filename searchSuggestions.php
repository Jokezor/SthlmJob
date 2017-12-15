<?php

   $wordfile = fopen("words_accepted.txt", "r") or die("Unable to open file!");


   /* get the q parameter from URL */
   $q = $_REQUEST["q"];

   $sugg[] = "";

   if ($q !== "") {
      $q = strtolower($q);
      $len=strlen($q);
      $suggIndex = 0;

      while(!feof($wordfile)) {
         $line = fgets($wordfile);
         $wordsInLine = explode(", ", $line);


         foreach($wordsInLine as $word){
            if(stristr($q, substr($word, 0, $len))){
               $sugg[$suggIndex] = $wordsInLine[0];
               $suggIndex += 1;
               break;
            }
         }
      }
      fclose($wordfile);
   }

   /* Output "no suggestion" if no hint was found or output correct values */
   if($sugg === ""){
      echo "No suggestions\n";
   }
   else{
      header("Content-type: text/xml");
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
      echo "<MATCHINGWORDS>";
      for($i = 0; $i < count($sugg); $i++){
         echo "<WORD> " . $sugg[$i] . " </WORD>";
      }
      echo "</MATCHINGWORDS>";
   }

?>
