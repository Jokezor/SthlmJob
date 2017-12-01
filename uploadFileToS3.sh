#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")
   if (b!="*") do
     php talktomeS3.php "$b"
     echo "$b"
     rm -f "$file"

   fi
   ls uploads

done
