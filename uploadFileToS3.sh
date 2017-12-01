#!/bin/bash

regex='^[]0-9a-zA-Z,!^`@{}=().;/~_|[-]+$'

for file in uploads/*; do

   b=$(basename "$file")
   if [ "$b" =~ $regex ]
   then
     php talktomeS3.php "$b"
     echo "$b"
     rm -f "$file"

   fi
   ls uploads

done
