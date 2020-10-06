<?php

class AdsModel {


            // TODO, ändra allt för att anpassa för Ads.


    //Database
    private $dbConnection;
    private $url;
    private $dbparts;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $tableName;
    private $dbColumnOneName = "car";
    private $dbColumnTwoName = "model";
    
    public function __construct(){   

        $this->url = $_SERVER["SERVER_NAME"] == "localhost" ?  : getenv('JAWSDB_URL');
        $this->dbparts = $_SERVER["SERVER_NAME"] == "localhost" ? "" : parse_url($this->url);
        $this->hostname = $_SERVER["SERVER_NAME"] == "localhost" ? "localhost:8889" : $this->dbparts['host'];
        $this->username = $_SERVER["SERVER_NAME"] == "localhost" ? "root" : $this->dbparts['user'];
        $this->password = $_SERVER["SERVER_NAME"] == "localhost" ? "root" : $this->dbparts['pass'];
        $this->database = $_SERVER["SERVER_NAME"] == "localhost" ? "cars" : ltrim($this->dbparts['path'],'/');
        $this->tableName = $_SERVER["SERVER_NAME"] == "localhost" ? "cars" : "cars";

        // Create connection
        $this->dbConnection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }

    private function createDatabase () {
        if($this->dbConnection->query("CREATE DATABASE $this->database") === TRUE){
        } else {
          echo "Error creating database: " . $this->dbConnection->error;
        }
    }

    public function createTableInDataBase () {
        $sql = "CREATE TABLE $this->tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            $this->dbColumnOneName VARCHAR(30) NOT NULL,
            $this->dbColumnTwoName VARCHAR(30) NOT NULL,s
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            
            if ($this->dbConnection->query($sql) === TRUE) {
            } else {
                echo "Error creating table: " . $this->dbConnection->error . ".";
            }
            if ($this->dbConnection->connect_error) {
                die("Connection failed: " . $this->dbConnection->connect_error);
            }
        }

    public function checkUserOnRegistration($username, $passwrd, $repeatedPasswrd){
        
        if(!$username and !$passwrd){
            return "Username has too few characters, at least 3 characters.<br>Password has too few characters, at least 6 characters.";
        }

        // Check username-----------------------------------------
        if(!$username) {
            return "Username has too few characters, at least 3 characters.";
        }

        if (strlen($username) < 3) {
            return "Username has too few characters, at least 3 characters.";
        }

        if (preg_match_all('/[<>!_]/', $username, $result)) {
            return "Username contains invalid characters.";
        }
        
        if($this->CheckIfUserExists($username)) {
            return "User exists, pick another username.";
        } 
        // Check password------------------------------------------
        if(!$passwrd) {
            return "Password has too few characters, at least 6 characters.";
        }

        if(strlen($passwrd) < 6){
            return "Password has too few characters, at least 6 characters.";
        }
        

        if($passwrd != $repeatedPasswrd) {
            return "Passwords do not match.";
        }

        $this->createUsernameAndPassword($username, $passwrd);
        return "User registered!";
    }

    public function CheckIfUserExists($username) {
        $sql = "SELECT username FROM $this->tableName WHERE username = '$username'";
        $existingUser = "";
        if ($result = $this->dbConnection->query($sql)) {

            while ($row = $result->fetch_row()) {
                $existingUser = strval($row[0]);
            }
            $result->close();
        }
        if($existingUser == $username) {
            return true;
        }else {
            return false;
        }
    }
        

    // TODO
    public function createUsernameAndPassword($username, $password) {
        try {
            $sql = "INSERT INTO $this->tableName (username, passwrd) VALUES ('$username', '')";
            $this->dbConnection->query($sql);
            header("Refresh:0; url=index.php");

        }catch(\Exception $error) {
            echo "fel vid skapande av table data " . $error;
        }
    }

}
