#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")

   php talktomeS3.php "$b"
   rm -f "$file"
   ls uploads

done
