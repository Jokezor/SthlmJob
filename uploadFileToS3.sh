#!/bin/bash

for file in /uvar/www/html/uploads/* ; do

   xbase=${file##*/}
   xfext=${xbase##*.}
   xpref=${xbase%.*}
   echo $xbase
   #echo $filename
   #php talktomeS3.php $file
   #rm $file
done
