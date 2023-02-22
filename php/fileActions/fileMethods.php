<?php
    include_once('../db/db.php');

    class fileMethods {
        private $dbCon;

        public function __construct($dbCon) {
            $this -> db = $dbCon;
        }

        public function uploadFileDB($username, $filename, $filedate, $filesize, $filetype, $description, $fileItemLink) {
            $sql = "INSERT INTO s3data(username, filename, filedate, filesize, filetype, description, fileItemLink) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'sssssss', $username, $filename, $filedate, $filesize, $filetype, $description, $fileItemLink);
            mysqli_stmt_execute($preparedStatement);
        }

        public function checkFilesOver50($username) {
            $sql = "SELECT * FROM s3data WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            if(mysqli_num_rows($result) >= 50) {
                return true;
            } else {
                return false;
            }
        }
        
        public function numberOfFilesPerAccount($username) {
            $sql = "SELECT * FROM s3data WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $numRows = mysqli_num_rows($result);
            return $numRows;
        }

        public function checkIfOverXFiles($username, $filesPerPage) {
            $sql = "SELECT * FROM s3data WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            if(mysqli_num_rows($result) > $filesPerPage) {
                return true;
            } else {
                return false;
            }
        }

        public function retrieveFilesUnderX($username) {
            $sql = "SELECT * FROM s3data WHERE username=? ORDER BY id DESC";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            return $result;
        }

        public function retrieveFilesOverX($username, $page, $postsPerPage) {
            $offset = ($page - 1) * $postsPerPage; // subtract 1 due to zero indexing with MYSQL offset values
            $sql = "SELECT * FROM s3data WHERE username=? ORDER BY id DESC LIMIT ?, ?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'sss', $username, $offset, $postsPerPage);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            return $result;
        }

        public function deleteSingleFile($id) {
            $sql = "DELETE FROM s3data WHERE id=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $id);
            mysqli_stmt_execute($preparedStatement);
        }

        public function getAllFiles($username) {
            $sql = "SELECT * FROM s3data WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql); 
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            return $result;
        }

        public function deleteAllFiles($username) {
            $sql = "DELETE FROM s3data WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_stmt_execute($preparedStatement);
        }

        public function deleteAccount($username) {
            $sql = "DELETE FROM users WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_stmt_execute($preparedStatement);
        }
    }
?>
