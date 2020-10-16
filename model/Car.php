<?php

// Did not have time to implement Car class in other modules....
namespace Model;

class Car {
    
    protected $id;
    protected $model = "";
    protected $mileage = "";
    protected $owner = "";

    public function __construct($id, $owner, $model , $mileage )
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->model = $model;
        $this->mileage = $mileage;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getOwnerName() {
        return $this->owner;
    }
    
    public function getModel() {
        return $this->model;
    }

    public function getMileage() {
        return $this->mileage;
    }

}