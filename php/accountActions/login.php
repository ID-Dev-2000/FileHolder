<?php
    error_reporting(0);
    // file exists to provide session variables with account data, JS file loads index.php
    include('../mainMethods.php');
    
    session_start();

    $methods = new dbHandle($con);

    if(isset($_POST)) {
        $received = file_get_contents('php://input');
        $decodedJSON = json_decode($received, true);
        $verifyAccount= $methods -> checkIfPasswordsMatch($decodedJSON['username'], $decodedJSON['password']);
        if($verifyAccount == false) {
            echo 'Password Incorrect.';
        } elseif($verifyAccount == true) {
            $_SESSION['username'] = $decodedJSON['username'];
            echo 'Password Correct.';
        }
    }
?>
