<?php
    include('../mainMethods.php');

    $methods = new dbHandle($con);

    if(isset($_POST)) {
        $received = file_get_contents('php://input');
        $decodedJSON = json_decode($received, true);
        $creationDate = date('D, M d, Y');
        $methods -> registerAccount($decodedJSON['username'], $decodedJSON['password'], $creationDate);
    }    
?>

