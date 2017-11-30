#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")
   php talktomeS3.php $b
   #rm $file
   i=i+1
done
