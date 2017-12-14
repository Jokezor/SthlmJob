<?php

$target_dir = "/var/www/html/uploads/";
$user_mail = htmlentities("joakim.olovsson@hotmail.com");
$fileType = "pdf";
$user_mail_tofile = $target_dir . $user_mail . "." .$fileType;
echo $user_mail_tofile;




?>
