<?php

namespace View;

class AdsView {
	private static $carModel = "AdsView::CarModel";
	private static $carMileage = "AdsView::CarMileage";
	private static $carOwner = "AdsView::CarOwner";
	private static $carOwnerPhoneNumber = "AdsView::CarPhoneNumber";
	private static $saveNewCar = "AdsView::SaveCar";

	private static $editCar = "AdsView::EditCar";
	private static $editCarModel = "AdsView::EditCarModel";
	private static $editCarMileage = "AdsView::EditCarMileage";
	private static $saveEditedCar = "AdsView::SaveEditedCar";

	private static $deleteCar = "AdsView::DeleteCar";

	private static $addCarString = "addCar";
	private static $editCarString = "editCar";
	private static $deleteCarString = "deleteCar";
	
	
	// Create car ad.
	public function addNewCar() {
		return isset($_GET[self::$addCarString]);
	}
	public function saveNewCar() {
		return isset($_POST[self::$saveNewCar]);
	}
	public function getCarModelName() {
		return $_POST[self::$carModel];
	}
	public function getCarMileage() {
		return $_POST[self::$carMileage];
	}
	public function getCarOwner() {
		return $_POST[self::$carOwner];
	}
	public function getCarOwnerPhoneNumber() {
		return $_POST[self::$carOwnerPhoneNumber];
	}

	// Edit car ad.
	public function editCar() {
		return isset($_GET[self::$editCarString]);
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
	public function getCarAdIdWhileEditing() {
		return $_GET[self::$editCarString];
	}
	public function getCarAdIdWhileDeleting() {
		return $_GET[self::$deleteCarString];
	}

	// Delete car ad.
	public function deleteCar() {
		return isset($_POST[self::$deleteCar]);
	}
	public function deleteCarAction() {
		return $_GET[self::$deleteCarString];
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
			return '<h2>Car ads</h2>'. $this->generateNewCarForm() .$returnString;
		} else if ($this->editCar()) {
			return '<h2>Car ads</h2>'. $this->generateEditCarForm() .$returnString;
		} else if ($this->deleteCarAction()) {
			return '<h2>Car ads</h2>'. $this->generateDeleteCarForm() .$returnString;
		}else {
			return '<h2>Car ads</h2>' . $returnString;	
		}
	}

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
					$returnString .= "Mileage: ". strval($row[2]) ."</div>";
					$returnString .= "<br>";
					$returnString .= "Owner: ". strval($row[3]) ."</div>";
					$returnString .= "<br>";
					$returnString .= "Phone number: ". strval($row[4]) ."</div>";
					$returnString .= "</div>";
					$returnString .= "</li>";
				}
				$returnString .= "</ul>";
			}
			return '<h2>Car ads</h2>' . $returnString;
		}
	}

	private function generateNewCarForm() {
		return 
		'<h3>Create new car ad</h3>
		<div class="formContainer">
			<form method="post">
				<label for="' . self::$carModel . '">Car model :</label>
				<select id="' . self::$carModel . '" name="' . self::$carModel . '">
					<option value="Volvo">Volvo</option>
					<option value="Saab">Saab</option>
					<option value="Fiat">Fiat</option>
					<option value="Audi">Audi</option>
				</select>
				<label for="' . self::$carMileage . '">Mileage :</label>
				<input type="text" id="' . self::$carMileage . '" name="' . self::$carMileage . '"maxlength="6" required/>

				<label for="' . self::$carOwner. '">Owner :</label>
				<input type="text" id="' . self::$carOwner . '" name="' . self::$carOwner . ' required/>

				<label for="' . self::$carOwnerPhoneNumber . '">Phone number :</label>
				<input type="text" id="' . self::$carOwnerPhoneNumber . '" name="' . self::$carOwnerPhoneNumber . '"maxlength="10" required/>
				
				<input type="submit" name="' . self::$saveNewCar . '" value="Save car" />
			</form>
		</div>';
	}

	private function generateEditCarForm() {
		return 
		'<h3>Edit car ad</h3>
		<div class="formContainer">
			<form method="post">
				<label for="' . self::$editCar . '">Car model :</label>
				<select id="' . self::$editCarModel . '" name="' . self::$editCarModel . '">
					<option value="Volvo">Volvo</option>
					<option value="Saab">Saab</option>
					<option value="Fiat">Fiat</option>
					<option value="Audi">Audi</option>
				</select>
				<label for="' . self::$editCarMileage . '">Mileage :</label>
				<input type="number" id="' . self::$editCarMileage . '" name="' . self::$editCarMileage . '" required/>
				
				<label for="' . self::$carOwner. '">Owner :</label>
				<input type="text" id="' . self::$carOwner . '" name="' . self::$carOwner . ' required/>
				
				<label for="' . self::$carOwnerPhoneNumber . '">Phone Number :</label>
				<input type="number" id="' . self::$carOwnerPhoneNumber . '" name="' . self::$carOwnerPhoneNumber . '"maxlength="10" required/>
				
				<input type="submit" name="' . self::$saveEditedCar . '" value="Save car" />
			</form>
		</div>';
	}
	private function generateDeleteCarForm() {
		return 
		'<h3>Delete car ad?</h3>
		<form method="post">
		<input type="submit" name="' . self::$deleteCar . '" value="Yes" />
		</form>
		';
	}
}