<?php 
require("../../config.php");

	session_start();
	
	


	function signup($email, $password) {

        $database = "if16_karojyrg_2";
		
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
        $stmt->close();
        $mysqli->close();
	}
	
	
	function login($email, $password) {

        $database = "if16_karojyrg_2";
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");

        echo $mysqli->error;

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
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: avalehekülg.php");
                exit();

			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud ühtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $error;
	}
	
	
	
	
	
	
	
	function save_voluntary_work($event_name,$place,$description,$date,$time){
		$database="if16_karojyrg_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	$stmt = $mysqli->prepare("INSERT INTO voluntary_work(event_name,place,description,date, time)VALUES(?,?,?,?,?,?)");
	echo $mysqli->error;
	$stmt-> bind_param("sssii",$event_name,$place,$description,$date,$time);
	if($stmt->execute()){
		echo "salvestamine õnnestus";
		
	}else{
		echo "ERROR".$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	}
	
	function get_all_voluntary_work(){
		$database="if16_karojyrg_2";
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli ->prepare("
		SELECT id, event_name, place, description, date, time
		FROM voluntary_work
		");
		echo $mysqli->error;
		
		$stmt ->bind_result($id, $event_name,$place, $description, $date, $time);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while($stmt->fetch()) {
			//tekitan objekti
			$voluntary = new StdClass();
			$voluntary->id = $id;
			$voluntary->nimi = $event_name;
			$voluntary->asukoht = $place;
			$voluntary->kirjeldus = $description;
			$voluntary->kuupäev = $date;
            $voluntary->kellaaeg = $time;
			
			//echo $plate."<br>";
			//igakord massivi lisan juurde nr märgi
			array_push($result,$voluntary);
		}
		
		
		
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
		
	}
	
	
	
	function cleanInput($input){
		$input = trim($imput);
		$input = htmlspecialchars($input);
		$input = stripslashes($input);
		return $imput;
		
	}
	
	
?>