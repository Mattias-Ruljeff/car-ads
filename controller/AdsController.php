<?php

namespace Controller;

use Model\Car;
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
		if ($this->view->saveCar()) {
            try {
                $carModel = $this->view->getCarModelName();
                $mileage = (int)$this->view->getCarMileage();
                $id = $this->model->getUniqueId();
                $newCar = new Car($id, "kalle", $carModel, $mileage);
                $this->model->createNewCarAd($newCar);

                return true;

			} catch (\Exception $e) {
                echo $e;
			}
		}
    }
    public function editCar()  {
        if ($this->view->saveEditedCar()) {
            try {
                $model = $this->view->getCarModelNameWhileEditingCar();
                $mileage = $this->view->getCarMileageWhileEditingCar();
                $id = $this->view->getCarAdIdWhileEditing();

                $this->model->editOneCarAd($id, $model, $mileage);

            } catch (\Exception $e) {
                echo $e;
            }
        }
    }
    public function deleteCar()  {
        if ($this->view->deleteCar()) {
            try {
                $id = $this->view->getCarAdIdWhileDeleting();

                $this->model->deleteOneCarAd($id);
                return true;

            } catch (\Exception $e) {
                echo $e;
            }
        }
    }

}