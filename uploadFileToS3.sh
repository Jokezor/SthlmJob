#!/bin/bash

for file in /var/www/html/uploads/* ; do

   xbase=${file##*/}
   xfext=${xbase##*.}
   xpref=${xbase%.*}
   echo $xfext
   #echo $filename
   #php talktomeS3.php $file
   #rm $file
done
