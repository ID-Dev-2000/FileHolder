<?php
    error_reporting(0);
    include('../mainMethods.php');

    $methods = new dbHandle($con);

    if(isset($_POST)) {
        $received = file_get_contents('php://input');
        $decodedJSON = json_decode($received, true);
        $responseVariable = $methods -> checkIfAccountExists($decodedJSON['username']);
        if($responseVariable == true) {
            echo "Username unavailable!";
        } else {
            echo "Username available!";
        }
    }    
?>
