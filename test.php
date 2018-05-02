<?php

if(!chdir('/var/www/html/uploads')){
   exit("chdir error");
}

$keyname = 'dbtable1te.txt';
$ext = end(explode(".",$keyname));
$email = str_replace("." . $ext, "", $keyname);


echo "ext: " . $ext;
echo "email: " . $email;
echo "keyname: " . $keyname;

$changename = 'mv /var/www/html/uploads/' . $keyname . ' /var/www/html/uploads/CV.' . $ext;

echo "\n Final: " . $changename;

system($changename);


?>
