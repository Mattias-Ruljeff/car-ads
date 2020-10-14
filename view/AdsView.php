<?php

namespace View;

class AdsView {
	private static $addcar = "AdsView::AddCar";
	private static $carModel = "AdsView::CarModel";
	private static $carMileage = "AdsView::CarMileage";
	private static $saveCar = "AdsView::SaveCar";
	private static $editCar = "AdsView::EditCar";

	private static $addCarString = "addCar";
	private static $editCarString = "editCar";


	public function addNewCar() {
		return isset($_GET[self::$addCarString]);
	}
	public function editCar() {
		return isset($_GET[self::$editCarString]);
	}
	public function saveCar() {
		return isset($_POST[self::$saveCar]);
	}
	public function getCarModelName() {
		return $_POST[self::$carModel];
	}
	public function getCarMileage() {
		return $_POST[self::$carMileage];
	}


	public function show($listOfAds) {

		$returnString = '<a href="?addCar">Add new car</a>';
		$returnString .= '<br>';
		if($listOfAds){
			$returnString .= "<ul>";
			while ($row = $listOfAds->fetch_row()) {
				$returnString .= "<li>" . strval($row[0]) . " ". strval($row[1]) . "</li>";
				$returnString .= '<a href="' . self::$editCar . '">Edit car</a>';
			}
			$listOfAds->close();
			$returnString .= "</ul>";
		}

		if($this->addNewCar()) {
			return '<h2>My cars</h2>
					'. $this->generateNewCarForm() .'
					<p>' . $returnString . '</p>';
		} else {
			return '<h2>My cars</h2>
					<p>' . $returnString . '</p>';
			
		}
	}

	private function generateNewCarForm() {
		return 
		'<form method="post">
			<label for="' . self::$carModel . '">Car model :</label>
			<input type="text" id="' . self::$carModel . '" name="' . self::$carModel . '" value="" />

			<label for="' . self::$carMileage . '">Mileage :</label>
			<input type="text" id="' . self::$carMileage . '" name="' . self::$carMileage . '" />
			
			<input type="submit" name="' . self::$saveCar . '" value="Save car" />
		</form>';
	}
}