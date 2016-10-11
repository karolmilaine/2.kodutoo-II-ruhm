<?php 




	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
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
	
    
?>

<h1 class="logo">
</h1>




<header>
<img src="logo.png" alt="Vabatahtlike klubi" style="width:150px;height:110px;">
<h1>Kesklinna noortekeskuse vabatahtlike klubi</h1>
</header>

<style>
header {
    padding: 1em;
    color: white;
    background-color: black;
    clear: left;
    text-align: center;
}
</style>
<?=$msg;?>


<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<p> <span style="font-family: tahoma, arial, helvetica, sans-serif;">
	Kesklinna noortekeskuse vabatahtlike klubi korraldab igakuiselt külastusi 
	erinevate organisatsioonide juurde, mis ühelt poolt omavad hariduslikku 
	aspekti ning teisalt täidavad abistamise eesmärki. Lisaks sellele püüab 
	klubi oma liikmetele vahendada võimalikult palju informatsiooni vabatahtliku 
	töö võimalustest üldiselt ning korraldada fun-üritusi tänuks tubli töö eest. 
	Mõned toimunud äramainimist väärivad ettevõtmised: Toidupanga abistamine, 
	Tallinn Music Week, Teeme Ära talgud, Tallinna Vanalinna Päevad jne.</span>
	</p>
	<p> <span style="font-family: tahoma, arial, helvetica, sans-serif;">
	Vabatahtlike klubi on avatud kõikidele huvilistele, 
	kuid eelkõige Kesklinna noortekeskuse sihtrühmale, 
	milleks on noored vanuses 16-26. Lisainfo: </span>
	<span id="cloak35897"><a 
	href="mailto:ivar@tallinnanoored.ee">ivar@tallinnanoored.ee</a>
	</span><script type="text/javascript">
 </script></p>
 
 <h4>Lahtiolekuajad</h4>
 <div class="bannergroup">
	Avatud: E-R 14-20:00

	<div class="bannerfooter">
		Suletud: L,P	</div>
</div>

<h4> Aadress </h4>
<div class="bannergroup">
	Raua 23, 10124 Tallinn

	<div class="bannerfooter">
		Tel. (+372)641 0021	</div>
</div>
 

	<a href="?logout=1">Logi välja</a>
</p>



