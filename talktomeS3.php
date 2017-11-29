<?php


putenv("HOME=/var/www/html");


require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
$bucket = 'sthlmjobcvinput1';
$keyname = 'README.md';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'eu-central-1'
]);



try {
    // Upload data.
    $result = $s3->putObject(array(
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'Body'   => 'this is the body!',
        'ACL'    => 'public'
    ));

    // Print the URL to the object.
    //echo $result['ObjectURL'] . "\n";
} //catch (S3Exception $e) {
    //echo $e->getMessage() . "\n";
//}


?>
