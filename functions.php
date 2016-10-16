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
				
				header("Location: avalehekülg.php");
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud ühtegi rida
			$notice = "Sellist emaili ei ole!";
		}
		
		return $notice;
	}
	
	
	
	
	
	
	
	function saveVabatahtliktoo($nimi,$kirjeldus,$aeg){
		$database="if16_karojyrg_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	$stmt = $mysqli->prepare("INSERT INTO Vabatahtliktoo(nimi,kirjeldus,aeg)VALUES(?,?,?)");
	echo $mysqli->error;
	$stmt-> bind_param("ss",$nimi,$kirjeldus);
	if($stmt->execute()){
		echo "salvestamine õnnestus";
		
	}else{
		echo "ERROR".$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	}
	
	function getAllVabatahtliktoo(){
		$database="if16_karojyrg_2";
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli ->prepare("
		SELECT id, nimi, kirjeldus, aeg
		FROM Vabatahtliktoo
		");
		echo $mysqli->error;
		
		$stmt ->bind_result($id, $nimi, $kirjeldus, $aeg);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while($stmt->fetch()) {
			//tekitan objekti
			$vabatahtlik=new StdClass();
			$vabatahtlik->id = $id;
			$vabatahtlik->nimi = $nimi;
			$vabatahtlik->kirjeldus = $kirjeldus;
			$vabatahtlik->aeg = $aeg;
			
			//echo $plate."<br>";
			//igakord massivi lisan juurde nr märgi
			array_push($result,$vabatahtlik);
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