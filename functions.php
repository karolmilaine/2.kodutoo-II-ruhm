<?php 
require("../../config.php");
	// functions.php
	
	// et saab kasutada $_SESSION muutujaid
	// kõigis failides mis on selle failiga seotud
	session_start();
	
	
	$database = "if16_karojyrg_2";
	
	//var_dump($GLOBALS);
	
	function signup($email, $password) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		// asendan ?
		$stmt->bind_param("s", $email);
		
		// määran muutujad reale mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		// ainult SLECTI'i puhul
		if ($stmt->fetch()) {
			
			// vähemalt üks rida tuli
			// kasutaja sisselogimise parool räsiks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				// õnnestus 
				echo "Kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION[message] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud ühtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	
	function saveCar($plate,$varv){
		$database="if16_karojyrg_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	$stmt = $mysqli->prepare("INSERT INTO cars_and_colors(plate,varv)VALUES(?,?)");
	echo $mysqli->error;
	$stmt-> bind_param("ss",$plate,$varv);
	if($stmt->execute()){
		echo "salvestamine õnnestus";
		
	}else{
		echo "ERROR".$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	}
	
	function getAllCars(){
		$database="if16_karojyrg_2";
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli ->prepare("
		SELECT id, plate, varv
		FROM cars_and_colors
		");
		echo $mysqli->error;
		
		$stmt ->bind_result($id, $plate, $varv);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while($stmt->fetch()) {
			//tekitan objekti
			$car=new StdClass();
			$car->id = $id;
			$car->plate = $plate;
			$car->varv = $varv;
			//echo $plate."<br>";
			//igakord massivi lisan juurde nr märgi
			array_push($result,$car);
		}
		
		
		
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
		
	}
	
	
	
	
	
	
	
	
	/*function sum($x, $y) {
		
		$answer = $x+$y;
		
		return $answer;
	}
	
	function hello($firstname, $lastname) {
		
		return 
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
		
	}
	
	echo sum(123123789523,1239862345);
	echo "<br>";
	echo sum(1,2);
	echo "<br>";
	
	$firstname = "Romil";
	
	echo hello($firstname, "R.");
	*/
?>