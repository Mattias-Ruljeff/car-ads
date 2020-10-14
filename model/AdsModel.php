<?php

namespace Model;

class AdsModel {

    private $tableName = "carads";
    private $dbColumnOneName = "model";
    private $dbColumnTwoName = "mileage";
    private $dbConnection;

    public function __construct(\Model\DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection->connect();
    }

    public function checkInputWhenCreatingAd($model, $mileage){
        
        if(!$model and !$mileage){
            return "Model has too few characters, at least 3 characters.<br>Mileage has too few characters, at least 6 characters.";
        }

        // Check username-----------------------------------------
        if(!$model) {
            return "Model has too few characters, at least 3 characters.";
        }

        if (strlen($model) < 3) {
            return "Model has too few characters, at least 3 characters.";
        }

        if (preg_match_all('/[<>!_]/', $model, $result)) {
            return "Ad contains invalid characters.";
        }
 
        if(!$mileage) {
            return "Mileage has too few characters, at least 6 characters.";
        }

        $this->createNewCarAd($model, $mileage);
        return "Ad created!";
    }
        
    public function createNewCarAd(string $carModel, string $mileage ) {
        try {
            $sql = "INSERT INTO carads ($this->dbColumnOneName, $this->dbColumnTwoName) VALUES ('$carModel', '$mileage')";
            $this->dbConnection->query($sql);
            header("Refresh:0; url=index.php");

        }catch(\Exception $error) {
            echo "Error creating ad" . $error;
        }
    }

    public function getAllAds() {
        $sql = "SELECT * FROM carads";
        return $this->dbConnection->query($sql);
    }


}
