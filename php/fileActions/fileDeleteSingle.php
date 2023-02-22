<?php
    session_start();
    include('../accountActions/accountConfirm.php');
    include('fileMethods.php');
    include('../requireAWS.php');
    include('../config.php');

    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;

    $fileMethods = new fileMethods($con);
    
    $bucket = $S3_BUCKET;
    
    $credentials = new Aws\Credentials\Credentials($ACCESS_KEY, $ACCESS_SECRET);
    $S3 = new S3Client([
        'region' => 'us-west-2',
        'version' => 'latest',
        'credentials' => $credentials
    ]);

    if(isset($_POST)) {
        $result = file_get_contents('php://input');
        $decoded = json_decode($result, true);
        $dbid = $decoded['dbid'];
        $fileKey = $decoded['key'];
        $username = $decoded['user'];

        $fileMethods -> deleteSingleFile($dbid);

        $S3 -> deleteObject([
            'Bucket' => $bucket,
            'Key' => $username . '/' . $fileKey
        ]);
    }
?>
