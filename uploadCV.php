<?php

$target_dir = "/var/www/html/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// Need to get email and remove @ and the dot before the ex .com to com
// First test with just $user_mail instead of targetfile $target_dir.$user_mail.$fileType
$user_mail = htmlentities($_POST['Mail']);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$user_mail_tofile = $target_dir . $user_mail . "." . $fileType;



  // Testing with $user_mail_tofile instead of $target_file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $user_mail_tofile)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }


?>
