#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")
   ba="${b//[[:space:]]/}"

   #php talktomeS3.php $ba
   echo "$file"
   #rm -f $file

done
