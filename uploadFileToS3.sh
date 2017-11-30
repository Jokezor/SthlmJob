#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")
   echo $b
   #echo $filename
   #php talktomeS3.php $file
   #rm $file
   i=i+1
done
