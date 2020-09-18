<?php


class DatabaseConnection {
    private $dbConnection;
    private $servername = "localhost:8889";
    private $username = "root";
    private $password = "root";
    private $dbname = "users";

    public function __construct(){
        
        // Create connection
        $this->dbConnection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // if($this->dbConnection->query("CREATE DATABASE $this->dbname") === TRUE){
        //     echo "Database created successfully";
        // } else {
        //   echo "Error creating database: " . $this->dbConnection->error;
        // }

        // $sql = "CREATE TABLE prutt (
        //     -- id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     username VARCHAR(30) NOT NULL,
        //     passwrd VARCHAR(30) NOT NULL,
        //     )";
        $sql = "CREATE TABLE prutt (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            passwrd VARCHAR(30) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            
            if ($this->dbConnection->query($sql) === TRUE) {
              echo "Table $this->dbname created successfully";
            } else {
              echo "Error creating table: " . $this->dbConnection->error . ".";
            }
        
        // Check connection
        if ($this->dbConnection->connect_error) {
            die("Connection failed: " . $this->dbConnection->connect_error);
        }
        echo " Connected successfully!";
    }

    public function createUsernameAndPassword($username, $password) {
        try {
            $this->dbConnection->query("INSERT INTO prutt (username, passwrd)
            VALUES ('John', 'Doe')");

        }catch(\Exception $error) {
            echo "fel vid skapande av table data " . $error;
        }
    }

    // Fixa denna, går fortfarande att "hitta användare"
    public function checkUsernameAndPassword($username, $password) {
        try {
            $sql = "SELECT * FROM prutt WHERE username = '$username' and passwrd = '$password' ";
            $query = $this->dbConnection->query($sql);
            if (!$query)
            {
                die('Error: ' . mysqli_error($this->dbConnection));
            }
        
            if(mysqli_num_rows($query) > 0){
                
                return true;
                
            }else{
                return false; 
        
        }

        }catch(\Exception $error) {
            echo " Fel användare eller lösen " . $error;
        }
    }

}
