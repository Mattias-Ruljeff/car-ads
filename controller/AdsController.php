<?php

namespace Controller;

class AdsController {

    private $view;

    public function __construct(\View\AdsView $view) {
        $this->view = $view;

    }

    public function addNewCar($dbConnection)  {
		if ($this->view->saveCar()) {
            echo "newCar-----------------------";
            try {
                $carModel = $this->view->getCarModelName();
                $mileage = (int)$this->view->getCarMileage();
                $dbConnection->createNewCarAd($carModel, $mileage);

                return true;

			} catch (\Exception $e) {
                echo $e;
			}
		}
	}
}