#!/bin/bash

for file in /var/www/html/uploads/*; do


   b=$(basename "$file")

   # If folder is empty $b ="*"
   if [[ $b != '*' ]]
   then
     #ls uploads
     $error = php /var/www/html/talktomeS3.php "$b"
     if($error){
       rm -f "$file"
     }
   fi

done
