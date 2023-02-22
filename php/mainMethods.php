<?php
    include_once('db/db.php');

    class dbHandle {

        private $dbCon;

        public function __construct($dbCon) {
            $this -> db = $dbCon;
        }
        
        public function registerAccount($username, $password, $createdate) {
            $sql = "INSERT INTO users(username, password, createdate) VALUES (?, ?, ?)";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'sss', $username, $password, $createdate);
            mysqli_execute($preparedStatement);
        }

        public function checkIfAccountExists($username) {
            $sql = "SELECT * FROM users WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            if(mysqli_num_rows($result) > 0) {
                return true; // account exists
            } else {
                return false; // account does not exist
            }
        }

        public function checkIfPasswordsMatch($username, $password) {
            $sql = "SELECT * FROM users WHERE username=? AND password=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ss', $username, $password);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            if(mysqli_num_rows($result) > 0) {
                return true; // 1, password matches account
            } else {
                return false; // 0, password does NOT match account
            } 
        }

        public function getAccountData($username) {
            $sql = "SELECT * FROM users WHERE username=?";
            $preparedStatement = mysqli_prepare($this -> db, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            return $row;
        }
    }
?>
