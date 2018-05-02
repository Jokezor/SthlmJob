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
$ext = end(explode(".",$keyname));
$email = str_replace("." . $ext, "", $keyname);
//s3cmd put uploads/$keyname s3://sthlmjobcvinput1/$email/CV.$ext

$commandString = 's3cmd put /var/www/html/uploads/' . $keyname . ' s3://sthlmjobcvinput1/' . $email . '/CV.' . $ext;
$access = 's3cmd sync --acl-public uploads/' . escapeshellarg($keyname) . ' s3://sthlmjobcvinput1/' . escapeshellarg($email) . '/CV.' escapeshellarg($ext);
/*
$path = "/var/www/html/uploads/" . $argv[1];

$path_parts = pathinfo($path);
$keyname = $path_parts['basename'];
$ext = $path_parts['extension'];
$file = $path_parts['filename'];
*/
$changename = 'mv ' . $keyname . ' CV.' . $ext;

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'eu-central-1'
]);

$result = 0;
try {
    // Upload data.

    //passthru($cmd, $result);
    //system($commandString);
    system($changename);
    $newFile = 'CV.' . $ext;

    $result = $s3->putObject(array(
                  'Bucket' => $bucket,
                  'Key'    => $email,
                  'Body' => EntityBody::factory(fopen($file, 'r'));
                  //'Body'   => file_get_contents("$newFile"),
                  'ACL'    => 'public-read',
                 ));

    //$filetype = "application/pdf";
    //'Metadata' => ['ContentType', 'application/pdf'],

    // Change filename

    //$filename = $keyname . $ext;

    /*
    $result = $s3->putObject(array(
        'Bucket' => $bucket,
        'Key'    => $keyname . "/" . $filename,
        # body needs to get the file contents.
        'ACL'    => 'public-read-write',
        'Body'   => file_get_contents("$filename"),
    ));
    */



    //sleep(5);
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
