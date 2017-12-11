<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

   /* Array with names */
   $arr[] = "cto";
   $arr[] = "ceo";

   /* get the q parameter from URL */
   $q = $_REQUEST["q"];

   $hint = "";

   /* lookup all hints from array if $q is different from "" */
   if ($q !== "") {
       $q = strtolower($q);
       $len=strlen($q);
       foreach($a as $name) {
           if (stristr($q, substr($name, 0, $len))) {
               if ($hint === "") {
                   $hint = $name;
               } else {
                   $hint .= ", $name";
               }
           }
       }
   }

   // Output "no suggestion" if no hint was found or output correct values
   echo $hint === "" ? "no suggestion" : $hint;
}
?>
