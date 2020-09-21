<?php


class DatabaseConnection {
    private $dbConnection;
    private $servername =  "localhost:8889";

    // Local host
    // private $username = "root";
    // private $password = "root";

    // Heroku
    // private $dbparts = $_SERVER["SERVER_NAME"] == "localhost" ? "localhost:8889" : parse_url($url);
    
    private $url;
    private $dbparts;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $tableName = "prutt";
    
    public function __construct(){   
        $this->url = getenv('JAWSDB_URL');
        $this->dbparts = parse_url($this->url);
        $this->hostname = $this->dbparts['host'];
        $this->username = $this->dbparts['user'];
        $this->password = $this->dbparts['pass'];
        $this->database = ltrim($this->dbparts['path'],'/');

        echo $this->dbparts;
        echo $this->database;
        $this->createDatabase();

        // Create connection
        $this->dbConnection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }

    private function createDatabase () {
        if($this->dbConnection->query("CREATE DATABASE $this->database") === TRUE){
            echo "Database created successfully";
        } else {
          echo "Error creating database: " . $this->dbConnection->error;
        }
    }

    public function createTableInDataBase () {
        $sql = "CREATE TABLE $this->tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            passwrd VARCHAR(30) NOT NULL,s
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
            $this->dbConnection->query("INSERT INTO $this->tableName (username, passwrd)
            VALUES ('John', 'Doe')");
            echo "";

        }catch(\Exception $error) {
            echo "fel vid skapande av table data " . $error;
        }
    }

    // Fixa denna, går fortfarande att "hitta användare"
    public function checkUsernameAndPassword($username, $password) {
        echo " checked username and passwrd 1 <br>";
        try {
            echo " checked username and passwrd 2 <br>";
            $sql = "SELECT * FROM $this->tableName WHERE username = '$username' and passwrd = '$password' ";
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
