#!/bin/bash

regex='^[]0-9a-zA-Z,!^`@{}=().;/~_|[-]+$'

for file in uploads/*; do


   b=$(basename "$file")
   ba=""${b//[[:space:]]/}""

   if [[ ! -z "$b" ]]
   then
     ls uploads
     php talktomeS3.php "$b"
     echo "$b"
     rm -f "$file"

   fi

done
