#!/bin/bash

for file in /var/www/html/uploads/* ; do
   php talktomeS3.php $file
   rm $file
done
