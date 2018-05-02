#!/bin/bash

for file in /var/www/html/uploads/*; do


   b=$(basename "$file")


   # If folder is empty $b ="*"
   if [[ $b != '*' ]]
   then

     #ls uploads
     php /var/www/html/talktomeS3.php "$b"

     rm -f "$file"

   fi

done
