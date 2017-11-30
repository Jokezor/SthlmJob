#!/bin/bash


for file in uploads/*; do

   b=$(basename "$file")
   ba="${b//[[:space:]]/}"
   filer="${file//[[:space:]]/}"

   #php talktomeS3.php $ba
   echo $filer
   #rm -f $file

done
