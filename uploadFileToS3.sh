#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")
   ba="${b//[[:space:]]/}"

   php talktomeS3.php "$b"
   rm -f "$file"
   ls uploads

done
