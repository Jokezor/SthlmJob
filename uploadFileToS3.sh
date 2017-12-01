#!/bin/bash

regex='^[]0-9a-zA-Z,!^`@{}=().;/~_|[-]+$'

for file in uploads/*; do


   b=$(basename "$file")
   ba=""${b//[[:space:]]/}""


      #if [[ "$ba" =~ "$regex" ]]
   if [[ "$b" -eq "*" ]]
   then
     ls uploads
     php talktomeS3.php "$b"
     echo "$b"
     rm -f "$file"

   fi

done
