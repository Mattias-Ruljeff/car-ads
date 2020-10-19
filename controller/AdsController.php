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
                $id = $this->model->getUniqueId();
                $carModel = $this->view->getCarModelName();
                $mileage = (int)$this->view->getCarMileage();
                $owner = $this->view->getCarOwner();
                $phoneNumber = $this->view->getCarOwnerPhoneNumber();
                echo $owner;
                echo $phoneNumber;
                
                $this->model->createNewCarAd($id, $carModel, $mileage, $owner, $phoneNumber);

                return true;

			} catch (\Exception $e) {
                echo $e;
			}
		}
    }
    public function editCar()  {
        if ($this->view->saveEditedCar()) {
            try {
                $id = $this->view->getCarAdIdWhileEditing();
                $model = $this->view->getCarModelNameWhileEditingCar();
                $mileage = $this->view->getCarMileageWhileEditingCar();
                $owner = $this->view->getCarOwner();
                $phoneNumber = $this->view->getCarOwnerPhoneNumber();

                $this->model->editOneCarAd($id, $model, $mileage, $owner, $phoneNumber);

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