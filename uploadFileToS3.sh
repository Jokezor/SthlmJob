#!/bin/bash

for file in /var/www/html/uploads/* ; do

   filename=$(basename "$file")
   echo $filename
   #php talktomeS3.php $file
   #rm $file
done
