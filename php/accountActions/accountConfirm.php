<?php
    // redirects user to index.php if not logged in while trying to access specific PHP pages
    if(!isset($_SESSION['username'])) {
        $linkToIndex = $_SERVER['SERVER_NAME'] . '/projects/fileHandlingS3/php/index.php';
        header('Location: http://' . $linkToIndex);
        exit;
    }
?>
