<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'fileholder';

    $con = mysqli_connect($hostname, $username, $password, $dbName);

    // check the connection
    if(mysqli_connect_errno()) {
        echo "Connection failed: " . mysqli_connect_error();
        exit();
    }
?>
