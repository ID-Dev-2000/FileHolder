<?php
    session_start();
    include('../accountActions/accountConfirm.php');
    include('../header.php');
    include('../requireAWS.php');
    include('fileMethods.php');
    include('../config.php');

    $fileMethods = new fileMethods($con);

    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;

    $credentials = new Aws\Credentials\Credentials($ACCESS_KEY, $ACCESS_SECRET);
    $S3 = new S3Client([
        'region' => 'us-west-2',
        'version' => 'latest',
        'credentials' => $credentials
    ]);

    $fileErrorUpdate = 0;
    if(isset($_POST['submit'])) {
        // establish file variables
        $username = $_SESSION['username'];                                                          // serves as folder name
        $fileName = substr(pathinfo($_FILES['fileUpload']['name'])['filename'], 0 , 30);            // unique file name
        $fileNameRandomized = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789_-'), 0, 30); // unique value for each post, prevents bruteforcing file URLs
        $uploadDate = date('D, M d, Y');
        $fileSizeValue = $_FILES['fileUpload']['size'];                                             // raw data in bytes of size of file
        $fileSizeText = '';                                                                         // variable will be updated with formatted file size data to be displayed in DB and in view file page
        $description = $_POST['descriptionText'];
        $fileIdentifier = '';                                                                       // used to determine file type in S3, image/, video/, text/
        $fileFromPOSTConfirm = is_uploaded_file($_FILES['fileUpload']['tmp_name']);                 // confirms if file comes from upload form
        $fileValid = 0;                                                                             // handles whether or not the file gets sent to DB/S3 or not, updated based on file data checks
        $fileErrorText = '';                                                                        // text to display upon error while checking file data
        $fileSource = $_FILES['fileUpload']['tmp_name'];                                            // temp file path, sends entire file to DB/S3
        $fileType = 'null';                                         

        // check if file uploaded from POST form
        if($fileFromPOSTConfirm == 1) {
            $fileType = strtolower(pathinfo($_FILES['fileUpload']['name'])['extension']);
            $fileValid = 1;
        } elseif($fileFromPOSTConfirm == 0) {
            $fileErrorUpdate = 1;
            $fileValid = 0;
            $fileErrorText = 'File Invalid! (Not sent from POST form)';
        }
        
        // check file type
        // file identifier used for S3 metadata
        if($fileFromPOSTConfirm == 1) {
            switch($fileType) {
                case('jpg');
                case('jpeg');
                case('png');
                case('gif');
                case('webp');
                $fileValid = 1;
                $fileIdentifier = 'image/';
                break;
                case('txt');
                $fileValid = 1;
                $fileIdentifier = 'text/';
                break;
                case('mp4');
                case('webm');
                $fileValid = 1;
                $fileIdentifier = 'video/';
                break;
                default;
                    $fileValid = 0;
                    $fileErrorUpdate = 1;
                    $fileErrorText = "Unsupported File Type!";
                }
            } elseif($fileFromPOSTConfirm == 0) {
                $fileValid = 0;
                $fileErrorUpdate = 1;
                $fileErrorText = "Please Upload File!";
            }
            
            // check description
            if(empty($description)) {
                $description = 'N/A';
            }
            
            // check number of files
            // true = over 50 files from account
            $numFiles = $fileMethods -> checkFilesOver50($username);
            if($numFiles == true) {
                $fileValid = 0;
                $fileErrorUpdate = 1;
                $fileErrorText = "Storage Full! Too Many Files On Account.";
            }
            
            // check file size
            if($fileSizeValue < 1048576) {                                                  // less than 1MB, returns KB result
                $fileValid = 1;
                $fileErrorUpdate = 0;
                $fileSizeText = substr(($fileSizeValue / 1024), 0, 5) . ' KB'; 
            } elseif($fileSizeValue <= 20971520 && $fileSizeValue >= 1048576) {             // between 20MB and 1MB, returns MB result
                $fileValid = 1;
                $fileErrorUpdate = 0;
                $fileSizeText = substr(($fileSizeValue * 0.00000095367432), 0, 4) . ' MB';
            } elseif($fileSizeValue > 20971520) {                                           // if too large, above 20MB, returns alert
                $fileValid = 0;
                $fileErrorUpdate = 1;
                $fileErrorText = "File Too Large! (Must be less than 20MB)";
                $fileSizeText = 'OVER 20 UNDER 40, MB';
            }

            if($fileType == 'null') {
                $fileValid = 0;
                $fileErrorUpdate = 1;
                $fileErrorText = "Please Upload File!";
            }

            // send file to DB/S3 if checks are valid
            if($fileValid == 1) {
                try {
                // send file information to DB
                $fileMethods -> uploadFileDB($username, $fileName, $uploadDate, $fileSizeText, $fileType, $description, $fileNameRandomized);

                // send file + file information to S3
                $metaData = [
                    'file-name' => $fileName,
                    'file-type' => $fileType,
                    'upload-date' => $uploadDate,
                    'username' => $username,
                    'description' => $description,
                ];

                $S3 -> putObject([
                    'Bucket' => $S3_BUCKET,
                    'Key' => $username . '/' . $fileNameRandomized . '.' . $fileType,
                    'SourceFile' => $fileSource,
                    'ACL' => 'public-read',
                    'ContentType' => $fileIdentifier . $fileType,
                    'Metadata' => $metaData
                ]);

                // redirect to view files after successful upload
                header('Location: fileRetrieve.php');
                exit;
            } catch(S3EXception $e) {
                echo $e -> getMessage() . '\n';
            }
        }
    }
?>

<body>
    <main class="columnCenter">
        <h1 style="margin: 4px 0px;">Upload Files</h1>
        <form method="post" enctype="multipart/form-data" class="columnCenter">
            <p style="margin-top: 0px;">Select file to upload:</p>
            <div class="columnCenter">
                <input type="file" name="fileUpload" id="idUpload" class="columnCenter fileUpload">
                <br>
                <label for="idDescription" style="font-size: small;">Description (Optional)</label>
                <input type="text" name="descriptionText" id="idDescription" placeholder="Description Text" class="columnCenter" maxlength="20">
                <br>
                <input type="submit" value="Upload Image" name="submit" class="columnCenter uploadButton">
            </div>
            <div class="columnCenter">
                <hr style="width: 100px;">
                <h3 style="margin: 0;">Info:</h3>
                <?php if($fileErrorUpdate == 1) { ?>
                    <div class="uploadError">
                        <p><?php echo $fileErrorText ?></p>
                    </div>
                <?php } ?>
                <div class="columnCenter">
                    <p class="columnCenter"><b>Valid File Types:</b> .jpg, .jpeg, .png, .gif, .webm, .webp, .mp4, .txt</p>
                    <p class="columnCenter"><b>Maximum File Size:</b> 20MB</p>
                    <p class="columnCenter"><b>File Limit:</b> 50 files per account</p>
                    <p class="columnCenter"><b>File Names:</b> File names over 30 chars are trimmed</p>
                    <div class="alertP columnCenter">
                        <b>ALERT!</b>
                        <p style="margin: 0;">Files are publicly visible via the source URL!</p>
                        <p style="margin: 0;">Be cautious uploading sensitive data!</p>
                    </div>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
