<?php

namespace Model;
use mysqli;

class DatabaseConnection {

    //Database
    private $dbConnection;
    private $url;
    private $dbparts;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $tablenameForUsers = "users";
    private $dbColumnUsername = "username";
    private $dbColumnPassword = "passwrd";
    private $hashCost = ["cost" => 8];
    
    public function __construct(){   

        $this->url = $_SERVER["SERVER_NAME"] == "localhost" ?  : getenv('JAWSDB_URL');
        $this->dbparts = $_SERVER["SERVER_NAME"] == "localhost" ? "" : parse_url($this->url);
        $this->hostname = $_SERVER["SERVER_NAME"] == "localhost" ? "localhost:8889" : $this->dbparts['host'];
        $this->username = $_SERVER["SERVER_NAME"] == "localhost" ? "root" : $this->dbparts['user'];
        $this->password = $_SERVER["SERVER_NAME"] == "localhost" ? "root" : $this->dbparts['pass'];
        $this->database = $_SERVER["SERVER_NAME"] == "localhost" ? "users" : ltrim($this->dbparts['path'],'/');

        // Create connection
        try {
            $this->dbConnection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Connection method, for other modules to be able to connect to the database.
     */
    public function connect() {
        return new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }

    // For later implementation, if database-table does not exist.
    public function createTableInDataBase ($tableName ,$dbColumnUsername, $dbColumnPassword) {
            $sql = "CREATE TABLE $tableName (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    $dbColumnUsername VARCHAR(30) NOT NULL,
                    $dbColumnPassword INT(10) NOT NULL,
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

    public function checkUsernameAndPasswordOnLogin($username, $passwrd) {
    
        if(!$username) {
            return "Username is missing";
        }
        if(!$passwrd) {
            return "Password is missing";
        }
        
        try{
            $result = $this->checkUserCredentials($username, $passwrd);
            if($result) {
                $_SESSION["username"] = $username;
                return "Welcome";
            } else {
                return "Wrong name or password";
            }
            
        }catch (\Exception $e) {
            echo "Error found " . $e->getMessage() . "\n";
        }
    }

    public function checkUserCredentials($username, $passwrd) {
        $dbPassword = "";
        try {
            $sql = "SELECT $this->dbColumnPassword FROM $this->tablenameForUsers WHERE $this->dbColumnUsername = '$username'";
            
            if ($result = $this->dbConnection->query($sql)) {

                while ($row = $result->fetch_row()) {
                    $dbPassword = strval($row[0]);
                }
                $result->close();
            }
            if ($this->readHashedPassword($passwrd, $dbPassword)) {
                return true;

            } else {
                return false;
            }
        }catch(\Exception $error) {
            echo " Wrong username or password " . $error;
        }
    }

    public function checkUseInputOnRegistration($username, $passwrd, $repeatedPasswrd){
        
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
        $sql = "SELECT $this->dbColumnUsername FROM $this->tablenameForUsers WHERE $this->dbColumnUsername = '$username'";
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

    public function createUsernameAndPassword($username, $password) {
        try {
            $hashedPassword = $this->passwordHash($password);
            $sql = "INSERT INTO $this->tablenameForUsers ($this->dbColumnUsername, $this->dbColumnPassword) VALUES ('$username', '$hashedPassword')";
            $this->dbConnection->query($sql);
            header("Refresh:0; url=index.php");

        }catch(\Exception $error) {
            echo "fel vid skapande av table data " . $error;
        }
    }

    private function passwordHash ($password) {
        return password_hash($password, PASSWORD_DEFAULT, $this->hashCost);
    }



    private function readHashedPassword ($password, $dbPassword) {
        return password_verify($password, $dbPassword);
    }
}
