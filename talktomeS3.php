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
    $result = $s3->putObject(array(
        'Bucket' => $bucket,
        'Key'    => $keyname,
        # body needs to get the file contents.
        'Body'   => file_get_contents("$keyname"),
        'ACL'    => 'public-read-write',
        'Content-Type' : 'application/pdf'
    ));

    // Print the URL to the object.
    //echo $result['ObjectURL'] . "\n";
    return 1;
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
    return 0;
}


?>
