#!/bin/bash

for file in /var/www/html/uploads/*; do


   b=$(basename "$file")

   # If folder is empty $b ="*"
   if [[ $b != '*' ]]
   then
     #ls uploads
     output = $(php /var/www/html/talktomeS3.php "$b")
     if [output]
     then
       rm -f "$file"
     else
       exit 0
     fi

   fi

done
