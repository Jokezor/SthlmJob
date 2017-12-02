<?php

# This is the directory where the uploads will be located.
if(!chdir('/var/www/html/')){
   exit("chdir error");
}
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// Need to get email and remove @ and the dot before the ex .com to com
// First test with just $user_mail instead of targetfile $target_dir.$user_mail.$fileType
$user_mail = htmlentities($_POST['Mail']);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$user_mail_tofile = $target_dir . $user_mail . "." . $fileType;

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

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  // Testing with $user_mail_tofile instead of $target_file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $user_mail_tofile)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>
