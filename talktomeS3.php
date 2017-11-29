<?php
// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'eu-central-1'
]);

?>

<?php

require '../vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
$bucket = 'sthlmjobcvinput1';
$keyname = 'README.md';

try {
    // Upload data.
    $result = $s3Client->putObject([
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'Body'   => 'this is the body!'
        'ACL'    => 'AKIAJM2ZOOVXDL4LC6BQ'
    ]);

    // Print the URL to the object.
    echo $result['ObjectURL'] . "\n";
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}


?>
