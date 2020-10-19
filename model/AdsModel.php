<?php

namespace Model;

class AdsModel {

    private static $tableCarAds = "carads";
    private static $dbColumnModel = "model";
    private static $dbColumnMileage = "mileage";
    private static $dbColumnOwner = "owner";
    private static $dbColumnPhoneNumber = "phonenumber";
    private static $dbColumnId = "id";
    private $dbConnection;

    public function __construct(\Model\DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection->connect();
    }
        
    public function createNewCarAd($id, $carModel, $mileage, $owner, $phoneNumber) {
        try {
            
            $sql = "INSERT INTO ".self::$tableCarAds." 
                (
                ".self::$dbColumnId.", 
                ".self::$dbColumnModel.",
                ".self::$dbColumnMileage.",
                ".self::$dbColumnOwner.",
                ".self::$dbColumnPhoneNumber."
                ) 
                VALUES (
                    '$id',
                    '$carModel',
                    '$mileage',
                    '$owner',
                    '$phoneNumber',
                    )";
            
            $this->dbConnection->query($sql);

            // header("Refresh:0; url=index.php");
        }catch(\Exception $error) {
            echo "Error creating ad" . $error;
        }
    }
    public function editOneCarAd(int $id, $model, $mileage, $owner, $phoneNumber) {
        try {
            $sql = "UPDATE ".self::$tableCarAds." SET
                    ".self::$dbColumnId." = '$id', 
                    ".self::$dbColumnModel." = '$model',
                    ".self::$dbColumnOwner." = '$owner'
                    ".self::$dbColumnPhoneNumber." = '$phoneNumber'
                    WHERE 
                    id= $id";
                    
            if($this->dbConnection->query($sql)){
            } else {
                throw new \Exception("Error editing car ad");
            }
    
            header("Refresh:0; url=index.php");
        }catch(\Exception $error) {
            echo "Error editing ad" . $error;
        }
    }
    public function deleteOneCarAd(int $id) {
        try {
            $sql = "DELETE FROM ".self::$tableCarAds." WHERE id= $id";
            if($this->dbConnection->query($sql)){
            } else {
                throw new \Exception("Error editing car ad");
            }
    
            header("Refresh:0; url=index.php");
        }catch(\Exception $error) {
            echo "Error editing ad" . $error;
        }
    }

    public function getAllAds() {
        $sql = "SELECT * FROM ".self::$tableCarAds ."";

        $result = $this->dbConnection->query($sql);
        $listOfAds = array();
        $i = 0;
        if($result){

            while ($row = $result->fetch_row()) {
                $listOfAds[$i] = $row;
                $i++;
            }
            $result->close();
        }
        return $listOfAds;
    }

    public function getUniqueId() {
        try {
            $fromDb = $this->getAllAds();
                foreach ($fromDb as $row) {
                $higherstId = 0;
                if ($higherstId < $row[0]){
                    $higherstId = $row[0];
                }
            }
            return $higherstId + 1;
            
        } catch (\Exception $th) {
            throw new \Exception("Error reading from database");
        }
    }
}
