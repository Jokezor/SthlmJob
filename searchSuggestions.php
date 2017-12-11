<?php
//if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
//   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

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
            }
         }
      }
   }

   /* lookup all hints from array if $q is different from "" */
   /*
   if ($q !== "") {
       $q = strtolower($q);
       $len=strlen($q);
       foreach($arr as $name) {
           if (stristr($q, substr($name, 0, $len))) {
               if ($hint === "") {
                   $hint = $name;
               } else {
                   $hint .= ", $name";
               }
           }
       }
   }*/

   /* Output "no suggestion" if no hint was found or output correct values */
   if($sugg === ""){
      echo "No suggestions\n";
   }
   else{
      for($i = 0; $i < count($sugg); $i++){
         echo $sugg[$i];
      }
   }
   fclose($wordfile);

?>
