<?php
if($argc != 2){
   exit("Not enough input args");
}

# This is the directory where the uploads will be located.
if(!chdir('/var/www/html/uploads')){
   exit("chdir error");
}

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
$bucket = 'sthlmjobcvinput1';
$keyname = $argv[1];

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'eu-central-1'
]);


try {
    // Upload data.
    $filetype = "application/pdf";
    $result = $s3->putObject(array(
        'Bucket' => $bucket,
        'Key'    => $keyname,
        # body needs to get the file contents.
        'ACL'    => 'public-read-write',
        'Metadata' => ['ContentType', 'application/pdf'],
        'Body'   => file_get_contents("$keyname"),
    ));

    sleep(5);
    /*
    $change = $s3->copyObject(array(
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'CopySource' => "{$bucket}/{$keyname}",
        //'MetadataDirective' => 'REPLACE'
        //'ContentType' => $filetype,
    ));
    */

    // Print the URL to the object.
    //echo $result['ObjectURL'] . "\n";
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}


?>
