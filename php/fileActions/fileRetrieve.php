<?php
    session_start();
    include('../accountActions/accountConfirm.php');
    include('../header.php');
    include('fileMethods.php');
    include('../config.php');
    
    $fileMethods = new fileMethods($con);

    $bucket = $S3_BUCKET;
    $username = $_SESSION['username'];
    $addPageButtons = false;
    $filesPerPage = 10;
    $currentPageLink = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if($fileMethods -> checkIfOverXFiles($username, $filesPerPage) == true && !isset($_GET['page'])) {
        $linkToIndex = $_SERVER['SERVER_NAME'] . '/projects/fileHandlingS3/php/fileActions/fileRetrieve.php';
        header('Location: http://' . $linkToIndex . '?page=1');
        exit;
    }

    if(isset($_GET['page'])) {
        $addPageButtons = true;
        $fileCount = ($_GET['page'] - 1) * $filesPerPage;
        $files = $fileMethods -> retrieveFilesOverX($username, $_GET['page'], $filesPerPage);
    }

    if(!isset($_GET['page'])) {
        $fileCount = 0;
        $files = $fileMethods -> retrieveFilesUnderX($username);
    }

?>

<body>
    <main class="columnCenter" id="tableMain">
        <div class="columnCenter">
            <h1 style="margin: 4px 0px;">View Files</h1>
            <p class="mobileIndicator">--></p>
            <img id="thumbnail" class="thumbnail" src="../../media/whiteSquare.jpg" alt="Thumbnails"></img>
        </div>
        <?php if($fileMethods -> numberOfFilesPerAccount($username) == 0) { ?>
            <p>Zero Files!</p>
        <?php } else {?>
            <div id="tableParent">
                <table id="fileTable">
                    <tr>
                        <td>#</td>
                        <td>Username</td>
                        <td>File Name</td>
                        <td>File Size</td>
                        <td>File Type</td>
                        <td>Upload Date</td>
                        <td>Description</td>
                    </tr>

                    <?php forEach($files as $item) { ?>
                    <?php // establish variables
                        $fileCount++;
                        $fileID          = $item['id'];
                        $fileUsername    = $item['username'];
                        $fileName        = $item['filename'];
                        $fileKey         = $item['fileitemlink'];
                        $fileType        = $item['filetype'];
                        $fileDate        = $item['filedate'];
                        $fileSize        = $item['filesize'];
                        $fileDescription = $item['description'];
                        $fileLink        = 'https://' . $bucket . '.s3.us-west-2.amazonaws.com/' . $fileUsername . '/' . $fileKey . '.' . $fileType;
                    ?>
                        <tr id="<?php echo $fileID ?>">
                            <td><?php echo $fileCount ?></td>
                            <td><?php echo $fileUsername ?></td>
                            <td><a href="<?php echo $fileLink ?>" target="_blank" class="linkCell" data-filetype="<?php echo $fileType ?>"><?php echo $fileName ?></a></td>
                            <td><?php echo $fileSize ?></td>
                            <td><?php echo $fileType ?></td>
                            <td><?php echo $fileDate ?></td>
                            <td><?php echo $fileDescription ?></td>
                            <td class="deleteButtonRow"><button class="fileDeleteButton" data-rowid="<?php echo $fileID ?>" data-key="<?php echo $fileKey . '.' . $fileType?>" data-username="<?php echo $fileUsername ?>">DELETE</button></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <!-- page buttons conditional -->
            <?php if($addPageButtons == true) { ?>
                <div class="pageButtonsParent">
                <?php
                    $limit = ceil(($fileMethods -> numberOfFilesPerAccount($username)) / $filesPerPage);
                    for($i = 1; $i <= $limit; $i++) {
                        $newlink = str_replace('page=' . $_GET['page'], 'page=' . $i, $currentPageLink);
                ?>
                    <a
                    href="<?php echo $newlink ?>"
                    class="pageButton <?php if($i == $_GET['page']) { ?> activePageButtonBackground <?php } ?>"
                    >
                    <div class="columnCenter">
                        <?php echo $i ?>
                    </div>
                </a>
                <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </main>
    <script src="../../js/fileRetrieveHandler.js"></script>
</body>
</html>
