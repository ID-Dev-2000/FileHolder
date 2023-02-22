<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileHolder</title>
    <link rel="stylesheet" href="../css/mainStyles.css"></link>
    <link rel="icon" href="../media/favicon-32x32.png"></link>
</head>
<body>
    <?php
    if(!isset($_SESSION['username'])) {
    ?>
    <!-- main content if not logged in begin -->
    <main class="columnCenter">
        <div class="mainContentParent">
            <div class="mainContent columnCenterNoVert">
                <h1 class="mainName">FileHolder</h1>
                <div class="columnCenter">
                    <p>Easily accessible cloud storage.</p>
                </div>
                <div class="columnCenter">
                    <button class="mainButton" id="loginButtonMain"><b>Login</b></button>
                    <button class="mainButton" id="registerButtonMain"><b>Register</b></button>
                    <a href="demonstration.php"><button class="mainButton" id="demonstrationButton"><b>Demonstration</b></button></a>
                    <button class="aboutButton" id="aboutButtonMain"><b>Learn more</b></button>
                </div>
                <br>
                <a href="https://github.com/ID-Dev-2000" target="_blank"><img src="../media/github-mark.png" style="width: 60px; height: 60px;"></img></a>
            </div>
        </div>
    </main>

    <!-- modals begin -->
    <div class="bodyBackground columnCenter" id="modalBackground" style="display: none;">
        <!-- login modal begin -->
            <div class="modalBox columnCenterNoVert" id="loginModal" style="display: none;">
            <div class="closeModalButton" id="closeModalButton">✕</div>
                <h1 id="loginH1Original">Login</h1>
                <div class="columnCenter">
                    <p class="wordBreak userUpdates" id="loginUsernameUpdate" style="display: none;"></p>
                    <label for="username">Username:</label>
                    <input type="text" name="usernameLogin" maxlength="30" id="usernameLoginID">
                    <br>
                    <p class="wordBreak userUpdates" id="loginPasswordUpdate" style="display: none;"></p>
                    <label for="password">Password:</label>
                    <input type="password" name="passwordLogin" maxlength="30" id="passwordLoginID">
                    <br>
                    <button type="submit" name="loginSubmit" class="loginRegisterButtons" id="loginButtonAction">LOGIN</button>
                    <p class="wordBreak userUpdates" id="loginState" style="display: none;">Invalid Credentials!</p>
                    <p class="wordBreak loginSuccess" id="loginState2" style="display: none;">Login Success!</p>
                    <p class="loadingText" style="display: none;">Loading</p>
                </div>
            </div>
        <!-- login modal end -->

        <!-- register modal begin -->
            <div class="modalBox columnCenterNoVert" id="registerModal" style="display: none;">
            <div class="closeModalButton" id="closeModalButton">✕</div>
                <h1>Register</h1>
                <div class="columnCenter">
                    <p class="wordBreak userUpdates" id="registerUsernameUpdate" style="display: none;"></p>
                    <p class="wordBreak userUpdates" id="registerUsernameUpdate2" style="display: none;"></p>
                    <label for="username">Username:</label>
                    <input type="text" name="usernameRegister" maxlength="30" id="usernameRegisterID">
                    <br>
                    <p class="wordBreak userUpdates" id="registerPasswordUpdate" style="display: none;"></p>
                    <label for="password">Password:</label>
                    <input type="password" name="passwordRegister" maxlength="30" id="passwordRegisterID">
                    <br>
                    <p class="wordBreak captchaUpdates" id="captchaUpdate" style="display: none;"></p>
                    <div class="captchaDisplay columnCenterNoVert">
                        <p class="captchaContent" id="captchaContent">CAPTCHA</p>
                        <input type="text" class="captchaInput" id="captchaInput" placeholder="CAPTCHA" maxlength="5">
                    </div>
                    <p style="font-size: smaller;" class="wordBreak">
                        CAPTCHA is case-insensitive.
                        <br>
                        Usernames and passwords can ONLY contain alphanumeric characters. (A-B, 0-9)
                    </p>
                    <button type="submit" name="registerSubmit" class="loginRegisterButtons" id="registerButtonAction">REGISTER</button>
                    <p class="registrationSuccess" id="registrationState" style="display: flex;">Registration successful!</p>
                    <p class="loadingText" style="display: none;">Loading</p>
                </div>
            </div>
        <!-- register modal end -->

        <!-- about modal begin -->
            <div class="aboutModal columnCenterNoVert" id="aboutModal" style="display: none;">
            <div class="closeModalButton" id="closeModalButton">✕</div>
                <h1>About</h1>
                <hr style="width: 100px;">
                <div class="columnCenterNoVert">
                    <p class="wordBreak">
                        Simple online storage.
                    </p>
                    <p class="wordBreak">
                        Holds plaintext files, images, and gifs.
                    </p>
                    <p class="wordBreak">
                        Maximum file size: 20MB
                    </p>
                    <p class="wordBreak">
                        Maximum number of files: 50 per account
                    </p>
                    <p class="wordBreak">
                        Be aware: files are publicly visible via the URL!
                    </p>
                    <p class="wordBreak">
                        You can delete all of your files and your account.
                    </p>
                    <hr style="width: 100px;">
                    <br>
                    <a href="https://aws.amazon.com/what-is-cloud-computing" target="_blank"><img src="https://d0.awsstatic.com/logos/powered-by-aws.png" alt="Powered by AWS Cloud Computing"></a>
                </div>
            </div>
            <script src="../js/md5.min.js"></script>
            <script src="../js/captcha.js"></script>
            <script src="../js/loginRegisterModals.js"></script>
        <!-- about modal end -->
    </div>
    <!-- modals end -->

    <!-- main content if not logged in end -->

    <?php } elseif(isset($_SESSION['username'])) {?>
    <!-- main content if logged in begin -->
    <main class="columnCenter">
        <div class="mainContentParent">
            <div class="mainContent columnCenterNoVert">
                <h1 class="mainName">FileHolder</h1>
                <div class="columnCenter">
                    <p>Logged in as: <span style="color: limegreen;"><?php echo $_SESSION['username'] ?></p>
                </div>
                <div class="columnCenter">
                    <a href="fileActions/fileUpload.php"><button class="mainButton"><b>Upload Files</b></button></a>
                    <a href="fileActions/fileRetrieve.php"><button class="mainButton"><b>View Files</b></button></a>
                    <button class="mainButton" id="logoutButton"><b>Logout</b></button>
                    <div class="logoutConfirmParent" id="logoutConfirmParent" style="display: none;">
                    <div class="columnCenterNoVert" id="confirmLogoutText">Confirm Logout?</div>
                        <button class="logoutConfirmDenyButton" id="logoutConfirm"><b>Yes</b></button>
                        <button class="logoutConfirmDenyButton" id="logoutDeny"><b>No</b></button>
                    </div>
                    <button class="aboutButton" id="aboutButtonMain"><b>Learn more</b></button>
                </div>
                <br>
                <a href="https://github.com/ID-Dev-2000" target="_blank"><img src="../media/github-mark.png" style="width: 60px; height: 60px;"></img></a>
            </div>
        </div>
    </main>

    <!-- about modal begin -->
    <div class="bodyBackground columnCenter" id="modalBackground" style="display: none;">
        <div class="aboutModal columnCenterNoVert" id="aboutModal" style="display: flex;">
            <div class="closeModalButton" id="closeModalButton">✕</div>
                <h1>About</h1>
                <hr style="width: 100px;">
                <div class="columnCenterNoVert">
                    <p class="wordBreak">
                        Simple online storage.
                    </p>
                    <p class="wordBreak">
                        Holds plaintext files, images, and gifs.
                    </p>
                    <p class="wordBreak">
                        Maximum file size: 20MB
                    </p>
                    <p class="wordBreak">
                        Maximum number of files: 50 per account
                    </p>
                    <p class="wordBreak">
                        Be aware: files are publicly visible via the URL!
                    </p>
                    <hr style="width: 100px;">
                    <br>
                    <a href="https://aws.amazon.com/what-is-cloud-computing" target="_blank"><img src="https://d0.awsstatic.com/logos/powered-by-aws.png" alt="Powered by AWS Cloud Computing"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- about modal end -->
    
    <!-- main content if logged in end -->

    <script src="../js/script.js"></script>
    <?php } ?>
</body>
</html>
