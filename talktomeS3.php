<?php include "../inc/dbinfo.inc";?>
<?php
  /* Connect to PostGreSQL and select the database. */
  $conn_string = "host=" . DB_SERVER . " port=5439 dbname=" . DB_DATABASE . " user=" . DB_USERNAME . " password=" . DB_PASSWORD;
  $db_connection =  pg_connect($conn_string) or die('Could not connect: ' . pg_last_error());
?>

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
//$changename = 'mv ' . $keyname . ' CV.' . $ext;

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'eu-central-1'
]);

try {
    // Upload data.

    //passthru($cmd, $result);
    //system($commandString);
    #system($changename);
    # New file name in each user's folder.
    $newFile = 'CV.' . $ext;

    $result = $s3->putObject(array(
                  'Bucket' => $bucket,
                  'Key'    => $email . "/" . $newFile,
                  'SourceFile' => $keyname,
                  'ContentType' => 'application/' . $ext,
                  'ACL'    => 'public-read',
                 ));



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


    $url = (string)$result['ObjectURL'];
    // Print the URL to the object.
    /*echo "\n" . "email: " . $email;
    echo $url . "\n";*/
    $result = pg_prepare($db_connection, "InsertURL", 'UPDATE person SET url = $1 where email=$2');
    $result = pg_execute($db_connection, "InsertURL", array($url,$email));
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}


?>
