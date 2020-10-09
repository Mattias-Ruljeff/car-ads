<?php

namespace Model;

class AdsModel {

    private $tableName = "cars";
    private $dbColumnOneName = "model";
    private $dbColumnTwoName = "mileage";

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

        $this->createNewAd($model, $mileage);
        return "Ad created!";
    }
        
    public function createNewAd(string $model, string $mileage ) {
        try {
            $sql = "INSERT INTO $this->tableName ($this->dbColumnOneName, $this->dbColumnTwoName) VALUES ('$model', '$mileage')";
            $this->dbConnection->query($sql);
            // header("Refresh:0; url=index.php");

        }catch(\Exception $error) {
            echo "Error creating ad" . $error;
        }
    }

}
