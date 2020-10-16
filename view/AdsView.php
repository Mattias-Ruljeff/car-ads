<?php

namespace View;

class AdsView {
	private static $addcar = "AdsView::AddCar";
	private static $carModel = "AdsView::CarModel";
	private static $carMileage = "AdsView::CarMileage";
	private static $saveCar = "AdsView::SaveCar";
	private static $saveEditedCar = "AdsView::SaveEditedCar";
	private static $editCar = "AdsView::EditCar";
	private static $editCarModel = "AdsView::EditCarModel";
	private static $editCarMileage = "AdsView::EditCarMileage";
	private static $deleteCar = "AdsView::DeleteCar";

	private static $addCarString = "addCar";
	private static $editCarString = "editCar";
	private static $deleteCarString = "deleteCar";


	public function addNewCar() {
		return isset($_GET[self::$addCarString]);
	}
	public function editCar() {
		return isset($_GET[self::$editCarString]);
	}
	public function deleteCar() {
		return isset($_GET[self::$deleteCarString]);
	}
	public function saveCar() {
		return isset($_POST[self::$saveCar]);
	}
	public function getCarAdIdWhileEditing() {
		return $_GET[self::$editCarString];
	}
	public function getCarAdIdWhileDeleting() {
		return $_GET[self::$deleteCarString];
	}
	public function getCarModelName() {
		return $_POST[self::$carModel];
	}
	public function getCarMileage() {
		return $_POST[self::$carMileage];
	}
	public function getCarModelNameWhileEditingCar() {
		return $_POST[self::$editCarModel];
	}
	public function getCarMileageWhileEditingCar() {
		return $_POST[self::$editCarMileage];
	}
	public function saveEditedCar() {
		return isset($_POST[self::$saveEditedCar]);
	}


	public function showAdsWithButtons($listOfAds) {

		$returnString = '<a href="?addCar">Add new car</a>';
		$returnString .= '<br>';
		if(count($listOfAds) > 0){
			$returnString .= "<ul>";
			foreach ($listOfAds as $row) {
				$returnString .= '<div class="ad">
									<li>
									<div id= '. $row[0] .' >
										Brand: ' . strval($row[1]) . '
										<br>
										Mileage: '. strval($row[2]). '
									</div>
									</li>
									<a href="?' . self::$editCarString . "=" . $row[0] .  '">Edit</a>
									<a href="?' . self::$deleteCarString . "=" . $row[0] .'">Delete</a>
									</div>';
			}
			$returnString .= "</ul>";
		}

		if($this->addNewCar()) {
			return '<h2>Cars</h2>'. $this->generateNewCarForm() .$returnString;
		} else if ($this->editCar()) {
			return '<h2>Cars</h2>'. $this->generateEditCarForm() .$returnString;
		}else {
			return '<h2>Cars</h2>' . $returnString;	

		}
	}//sa d

	public function showOnlyAds($listOfAds) {

		if (count($listOfAds) > 0){
			$returnString = '<br>';
			if($listOfAds){
				$returnString .= "<ul>";
				foreach ($listOfAds as $row) {
					$returnString .= "<li>";
					$returnString .= "<div class='ad'>";
					$returnString .= "<div id=". strval($row[0]) .">";
					$returnString .= "Brand: ". strval($row[1]);
					$returnString .= "<br>";
					$returnString .= "<nobr>Mileage: ". strval($row[2]) ."</nobr></div>";
					$returnString .= "</div>";
					$returnString .= "</li>";
				}
				$returnString .= "</ul>";
			}
			return '<h2>Cars</h2>' . $returnString;
		}
	}



	private function generateNewCarForm() {
		return 
		'<form method="post">
			<label for="' . self::$carModel . '">Car model :</label>
			<select id="' . self::$carModel . '" name="' . self::$carModel . '">
				<option value="Volvo">Volvo</option>
				<option value="Saab">Saab</option>
				<option value="Fiat">Fiat</option>
				<option value="Audi">Audi</option>
			</select>
			<label for="' . self::$carMileage . '">Mileage :</label>
			<input type="text" id="' . self::$carMileage . '" name="' . self::$carMileage . '"maxlength="6"/>
			
			<input type="submit" name="' . self::$saveCar . '" value="Save car" />
		</form>';
	}

	private function generateEditCarForm() {
		return 
		'<form method="post">
			<label for="' . self::$editCar . '">Car model :</label>
			<select id="' . self::$editCarModel . '" name="' . self::$editCarModel . '">
				<option value="Volvo">Volvo</option>
				<option value="Saab">Saab</option>
				<option value="Fiat">Fiat</option>
				<option value="Audi">Audi</option>
			</select>
			<label for="' . self::$editCarMileage . '">Mileage :</label>
			<input type="text" id="' . self::$editCarMileage . '" name="' . self::$editCarMileage . '" />
			
			<input type="submit" name="' . self::$saveEditedCar . '" value="Save car" />
		</form>';
	}
}