<?php

namespace Controller;

class AdsController {

    private $view;
    private $model;

    public function __construct(\View\AdsView $view, \Model\AdsModel $model) {
        $this->view = $view;
        $this->model = $model;
    }
    
    public function getAllAds () {
        $this->model->getAllAds();
    }
    public function addNewCar()  {
		if ($this->view->saveNewCar()) {
            try {
                $carModel = $this->view->getCarModelName();
                $mileage = (int)$this->view->getCarMileage();
                $id = $this->model->getUniqueId();
                
                $this->model->createNewCarAd($id, $carModel, $mileage);

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
        if ($this->view->deleteCarAction()) {
            try {
                if($this->view->deleteCar()){
                    $id = $this->view->getCarAdIdWhileDeleting();
                    $this->model->deleteOneCarAd($id);

                }
                return true;

            } catch (\Exception $e) {
                echo $e;
            }
        }
    }

}