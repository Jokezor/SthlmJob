#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")

   php talktomeS3.php "$b"
   echo "$b"
   rm -f "$file"
   ls uploads

done
