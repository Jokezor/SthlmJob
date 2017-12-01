#!/bin/bash



for file in uploads/*; do


   b=$(basename "$file")

   # If folder is empty $b ="*"
   if [[ "$b" != * ]]
   then
     ls uploads
     php talktomeS3.php "$b"
     echo "$b"
     rm -f "$file"
   fi

done
