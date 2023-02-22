<?php
    session_start();
    include('accountConfirm.php');
    include('../header.php');
    include('../mainMethods.php');
    include('../fileActions/fileMethods.php');

    $fileData = new fileMethods($con);
    $accountData = new dbHandle($con);

    $username = $_SESSION['username'];
    $numFiles = $fileData -> numberOfFilesPerAccount($username);
    $accountData = $accountData -> getAccountData($username);

?>

<body>
    <main class="columnCenter">
        <h1 style="margin: 4px 0px;">Account Details</h1>
        <div class="accountDetailsParent columnCenterNoVert">
            <p style='margin: 8px;'><b>Account:</b><span style="color: limegreen;"> <?php echo $username ?> </span></p>
            <p style='margin: 8px;'><b>Number of Files:</b> <?php echo $numFiles ?> </p>
            <p style='margin: 8px;'><b>Account Creation Date:</b> <br> <?php echo $accountData['createdate'] ?> </p>
            <div class="deleteRow">
                <div>
                    <button id="deleteAllFilesButton" class="columnCenter" style='margin: 16px;'>DELETE ALL FILES</button>
                    <div id="deleteAllFilesConfirmParent" style="display: none;">
                        <p style="margin: 0;" class="deleteRow">Are you sure?</p>
                        <div class="deleteRow" id="deleteAllFilesConfirmButtons">
                            <a class="deleteLink" href="deleteAllFiles.php"><span class="accountLink" id="deleteFilesYes">Yes</span></a>&nbsp;/&nbsp; <span class="accountLink" id="deleteFilesNo">No</span>
                        </div>
                    </div>
                </div>
                <div>
                    <button id="deleteAccountButton" class="columnCenter" style='margin: 16px;'>DELETE ACCOUNT</button>
                    <div id="deleteAccountConfirmParent" style="display: none;">
                        <p style="margin: 0;" class="deleteRow">Are you sure?</p>
                        <div class="deleteRow" id="deleteAccountConfirmButtons">
                            <a class="deleteLink" href="deleteAccount.php"><span class="accountLink" id="deleteAccountYes">Yes</span></a>&nbsp;/&nbsp;<span class="accountLink" id="deleteAccountNo">No</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../../js/accountHandler.js"></script>
</body>
</html>
