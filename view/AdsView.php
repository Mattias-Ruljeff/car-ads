<?php

namespace View;

class AdsView {
	private static $addcar = "AdsView::AddCar";
	private static $carModel = "AdsView::CarModel";
	private static $carMileage = "AdsView::CarMileage";
	private static $saveCar = "AdsView::SaveCar";


	public function addNewCar() {
		return isset($_GET["addCar"]);
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


	public function show() {

		$returnString = '<a href="?addCar">Add new car</a>';
		$returnString .= "Car 1: Nissan";
		$returnString .= "<br>";
		$returnString .= "Car 2: Toyota ";
		$returnString .= "<br>";
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