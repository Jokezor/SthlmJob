#!/bin/bash

for file in /var/www/html/uploads/*; do


   b=$(basename "$file")
   $fullname = $b;
  ($path,$name) = $fullname =~ /^(.*[^\\]\/)*(.*)$/;
  ($basename,$extension) = $name =~ /^(.*)(\.[^.]*)$/;


   # If folder is empty $b ="*"
   if [[ $b != '*' ]]
   then

     #ls uploads
     php /var/www/html/talktomeS3.php "$basename" "$extension"

     rm -f "$file"
     fi

   fi

done
