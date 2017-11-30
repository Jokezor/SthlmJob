#!/bin/bash

for file in /var/www/html/uploads/* ; do
   echo $file
   #filename=$(basename "$file")
   #$filename="/var/www/html/uploads/$filename"
   #echo $filename
   #php talktomeS3.php $file
   #rm $file
done
