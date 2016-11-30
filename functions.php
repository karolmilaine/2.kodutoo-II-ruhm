<?php
require("../../config.php");
session_start();

$database = "if16_karojyrg_2";

//***************
//**** SIGNUP ***
//***************

function signup($email, $password, $gender) {

    $mysqli = new mysqli(

        $GLOBALS["serverHost"],
        $GLOBALS["serverUsername"],
        $GLOBALS["serverPassword"],
        $GLOBALS["database"]

    );
    $stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, gender) VALUES (?, ?, ?)");
    echo $mysqli->error;

    $stmt->bind_param("sss", $email, $password, $gender );
    if ( $stmt->execute() ) {
        echo "salvestamine õnnestus";
    } else {
        echo "ERROR ".$stmt->error;
    }
    $stmt->close();
    $mysqli->close();
}

//***************
//**** LOGIN ****
//***************

function login($email, $password) {
    $database = "if16_karojyrg_2";

    $error = "";

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);

    $stmt = $mysqli->prepare("
		
			SELECT id, email, password, created, gender
			FROM user_sample
			WHERE email = ?
		
		");
    echo $mysqli->error;
    // asendan ?
    $stmt->bind_param("s", $email);

    // määran muutujad reale mis kätte saan
    $stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created, $genderFromDB);

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

            $_SESSION["userGender"] = ucfirst($genderFromDB);

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

    $stmt->close();
    $mysqli->close();
}


//*********************
//***VOLUNTARY WORK ***
//*********************

function save_voluntary_work($event_name,$place,$description,$date,$time){
    $database="if16_karojyrg_2";
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
    $stmt = $mysqli->prepare("INSERT INTO voluntary_work(event_name,place,description,date, time)VALUES(?,?,?,?,?)");
    echo $mysqli->error;
    $stmt-> bind_param("sssss",$event_name,$place,$description,$date,$time);
    if($stmt->execute()){
        echo "salvestamine õnnestus";

    }else{
        echo "ERROR".$stmt->error;
    }
    $stmt->close();

	

}


//*********************
//***VOLUNTARY WORK ***
//*********************

function save_user_voluntary_work ($work_id){
    $database="if16_karojyrg_2";
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
    $stmt = $mysqli->prepare("SELECT id FROM user_voluntary_work WHERE user_id=? AND work_id=?");
    $stmt->bind_param("ii",$_SESSION["userId"], $work_id);
    $stmt->execute();

    if($stmt->fetch()){
        echo "juba olemas";

        return;
    }

    $stmt->close();

    $stmt = $mysqli->prepare("INSERT INTO user_voluntary_work(user_id, work_id)VALUES (?,?)");

    echo $mysqli->error;
    $stmt->bind_param("ii",$_SESSION["userId"], $work_id);
    if($stmt->execute()) {
        echo "salvestamine õnnestus";
    } else {
        echo "ERROR ".$stmt->error;
    }
    $stmt->close();


}


//*********************
//***VOLUNTARY WORK ***
//*********************


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
        $i = new StdClass();
        $i->id = $id;
        $i->event_name = $event_name;
        $i->place = $place;
        $i->description = $description;
        $i->date = $date;
        $i->time = $time;

        //igakord massivi lisan juurde nr märgi
        array_push($result,$i);
    }




    $stmt->close();

    return $result;

}

//*********************
//***VOLUNTARY WORK ***
//*********************

function get_all_user_voluntary_work(){
    $database="if16_karojyrg_2";
    $mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

    $stmt = $mysqli->prepare("SELECT event_name from voluntary_work join user_voluntary_work
    on voluntary_work.id = user_voluntary_work.work_id where user_voluntary_work.user_id = ?");

    echo $mysqli->error;

    $stmt->bind_param("i", $_SESSION["userId"]);

    $stmt->bind_result($voluntary_work);
    $stmt->execute();

    $result = array();
    while ($stmt->fetch()) {
        $i = new StdClass();
        $i-> voluntary_work = $voluntary_work;
        array_push($result, $i);
    }
    $stmt->close();
    return $result;
}




//***************
//** CLEANINPUT *
//***************

function cleanInput($input){
    $input = trim($imput);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $imput;

}

?>



