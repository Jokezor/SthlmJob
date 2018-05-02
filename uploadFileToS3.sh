#!/bin/bash

for file in /var/www/html/uploads/*; do


   b=$(basename "$file")


   # If folder is empty $b ="*"
   if [[ $b != '*' ]]
   then

     #ls uploads
     result = $(php /var/www/html/talktomeS3.php "$b")
     
     if [$? -eq 0]
     then
       rm -f "$file"
     fi

   fi

done
