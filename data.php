<?php 
	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	
	//kas kasutaja tahab välja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
		
	
	}
	
	var_dump($_POST);
	
    if(isset($_POST["plate"]) &&
	isset($_POST["varv"])&&
	!empty($_POST["plate"])&&
	!empty($_POST["varv"])
	){
		saveCar(cleanInput($_POST["plate"]),$_POST["varv"]);
    }
	
	//saan kõik auto andmed
	getAllCars();
	echo "<pre>";

	
	//saan kõik auto andmed
	$carData = getAllCars();
	//var_dump($carData);
	
	echo "</pre>";
?>


<h1>Data</h1>
<?=$msg;?>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<h2>Salvesta auto</h2>

<form method="POST">


<input name="plate" type=text placeholder="Auto nr">
<br><br>
<label> Sisestage auto varv</label><br>


<input name="varv" type=color placeholder="Auto varv">
<br><br>
<input type="submit" value="Salvesta">

</form>

<h2>Autod</h2>
<?php

$html = "<table>";

$html .= "<tr>";
	$html .= "<th>id</th>";
	$html .= "<th>plate</th>";
	$html .= "<th>varv</th>";

$html .= "</tr>";


//iga liikme kohta massiivis
foreach($carData as $c){
	
	$html .= "<tr>";
	$html .= "<td>".$c->id."</td>";
	$html .= "<td>".$c->plate."</td>";
	$html .= "<td style='background-color:".$c->varv."'>".$c->varv."</td>";

$html .= "</tr>";

	//iga auto on $c
	//echo $c->plate."<br>";
	
}
$html .= "</table>";

echo $html;



$listHtml = "<br><br>";
foreach($carData as $c){
	$listHtml .= "<h1 style = 'color:".$c->varv."'>".$c->plate."</h1>";
	
}
echo $listHtml;


?>
