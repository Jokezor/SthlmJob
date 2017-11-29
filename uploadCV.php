<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
echo "YAYAYAYA";
echo $fileType;


/* Check file size */
if ($_FILES["fileToUpload"]["size"] > 1500000) {
   echo "Sorry, your file is too large.";
   $uploadOk = 0;
}

/* Allow certain file formats */
if($fileType != "doc" && $fileType != "docx" && $fileType != "pdf"
&& $fileType != "rtf" && $fileType != "txt" && $fileType != "odt" && $fileType != "wps") {
    echo "Format not supported";
    $uploadOk = 0;
}


?>
