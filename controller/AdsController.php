<?php

namespace Controller;

use Model\SessionModel;

class AdsController {

    private $view;
    private $model;
    private $sessionModel;

    public function __construct(\View\AdsView $view, \Model\AdsModel $model) {
        $this->view = $view;
        $this->model = $model;
    }
    
    public function getAllAds () {
        $this->model->getAllAds();
    }
    public function addNewCar()  {
		if ($this->view->editCar()) {
            try {
                $carModel = $this->view->getCarModelName();
                $mileage = (int)$this->view->getCarMileage();
                $this->model->createNewCarAd($carModel, $mileage);

                return true;

			} catch (\Exception $e) {
                echo $e;
			}
		}
    }
    public function editCar()  {
        if ($this->view->editCar()) {
            try {
                

                return true;

            } catch (\Exception $e) {
                echo $e;
            }
        }
    }

}