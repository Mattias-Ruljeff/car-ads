<?php

use function PHPSTORM_META\type;

class DatabaseConnection {

    //Database
    private $dbConnection;
    private $url;
    private $dbparts;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $tableName;
    private $dbColumnOneName = "username";
    private $dbColumnTwoName = "passwrd";
    private $hashCost = ["cost" => 8];
    
    public function __construct(){   

        $this->url = $_SERVER["SERVER_NAME"] == "localhost" ?  : getenv('JAWSDB_URL');
        $this->dbparts = $_SERVER["SERVER_NAME"] == "localhost" ? "" : parse_url($this->url);
        $this->hostname = $_SERVER["SERVER_NAME"] == "localhost" ? "localhost:8889" : $this->dbparts['host'];
        $this->username = $_SERVER["SERVER_NAME"] == "localhost" ? "root" : $this->dbparts['user'];
        $this->password = $_SERVER["SERVER_NAME"] == "localhost" ? "root" : $this->dbparts['pass'];
        $this->database = $_SERVER["SERVER_NAME"] == "localhost" ? "users" : ltrim($this->dbparts['path'],'/');
        $this->tableName = $_SERVER["SERVER_NAME"] == "localhost" ? "Test" : "test";

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
        

    public function createUsernameAndPassword($username, $password) {
        try {
            $hashedPassword = $this->passwordHash($password);
            print_r($hashedPassword);
            $sql = "INSERT INTO $this->tableName (username, passwrd) VALUES ('$username', '$hashedPassword')";
            $this->dbConnection->query($sql);

        }catch(\Exception $error) {
            echo "fel vid skapande av table data " . $error;
        }
    }

    public function checkUserCredentials($username, $passwrd) {
        echo "checkUserCredentials<br>";
        echo $username . "<br>";
        echo $passwrd . "<br>";
        echo "checkUserCredentials<br>";

        echo "getpasswrd 1 ";
        try {
            $sqlpasswrd = $this->dbConnection->query("SELECT * FROM $this->tableName WHERE username = 'hej'");
            echo "<br>-------sqlpass-------<br>";
            var_dump($sqlpasswrd);
            echo "<br>-------sqlpass-------<br>";
            $hashedPassword = $this->readHashedPassword($passwrd, $sqlpasswrd);
            echo "getpasswrd 2 ";
            var_dump($hashedPassword);
            $sql = "SELECT * FROM $this->tableName WHERE $this->dbColumnOneName = '$username' and $this->dbColumnTwoName = '$hashedPassword'";
            $query = $this->dbConnection->query($sql);
            if (!$query)
            {
                die('Error: ' . mysqli_error($this->dbConnection));
            }
            if(mysqli_num_rows($query) > 0){ 
                return true;
            } else{
                return false; 
            }
        }catch(\Exception $error) {
            echo " Wrong username or password " . $error;
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
            echo "  kolla cred 1  <br>";
            $test = $this->checkUserCredentials($username, $passwrd);
            echo "  kolla cred 2  <br>";
            print_r($test);
            if($test) {
                echo "  kolla cred   ";
                $_SESSION["username"] = $username;
                return "Welcome";
            } else {
                return "Wrong name or password";
            }
            
        }catch (Exception $e) {
            echo "Error found " . $e->getMessage() . "\n";
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
        
        if($this->checkUserCredentials("username", $username)) {
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
        header("Refresh:0; url=index.php");
        return "User registered!";
    }

    private function readHashedPassword ($password, $dbPassword) {
        echo " hashing ";
        echo $password;
        var_dump($dbPassword);
        return password_verify($password, $dbPassword);
    }
    private function passwordHash ($password) {
        return password_hash($password, PASSWORD_DEFAULT, $this->hashCost);
    }

}
