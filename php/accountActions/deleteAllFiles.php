<?php
    session_start();
    include('accountConfirm.php');
    include('../fileActions/fileMethods.php');
    include('../requireAWS.php');
    include('../config.php');

    $fileMethod = new fileMethods($con);

    $username = $_SESSION['username'];

    // delete from S3
    $credentials = new Aws\Credentials\Credentials($ACCESS_KEY, $ACCESS_SECRET);
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;
    
    $S3 = new S3Client([
        'region' => 'us-west-2',
        'version' => 'latest',
        'credentials' => $credentials
    ]);
        
    $allFiles = $fileMethod -> getAllFiles($username);
    
    // delete all files from S3
    forEach($allFiles as $item) {
        $S3 -> deleteObject([
            'Bucket' => $S3_BUCKET,
            'Key' => $username . '/' . $item['fileitemlink'] . '.' . $item['filetype']
        ]);
    }
    
    // delete from DB
    $fileMethod -> deleteAllFiles($username);

    $linkToIndex = $_SERVER['SERVER_NAME'] . '/projects/fileHandlingS3/php/index.php';
    header('Location: http://' . $linkToIndex);
    exit;
?>
