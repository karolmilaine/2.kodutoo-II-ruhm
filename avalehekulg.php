<?php 




	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	
	//kas kasutaja tahab v�lja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		//kui �he n�itame siis kustuta �ra, et p�rast refreshi ei n�itaks
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
	Kesklinna noortekeskuse vabatahtlike klubi korraldab igakuiselt k�lastusi 
	erinevate organisatsioonide juurde, mis �helt poolt omavad hariduslikku 
	aspekti ning teisalt t�idavad abistamise eesm�rki. Lisaks sellele p��ab 
	klubi oma liikmetele vahendada v�imalikult palju informatsiooni vabatahtliku 
	t�� v�imalustest �ldiselt ning korraldada fun-�ritusi t�nuks tubli t�� eest. 
	M�ned toimunud �ramainimist v��rivad ettev�tmised: Toidupanga abistamine, 
	Tallinn Music Week, Teeme �ra talgud, Tallinna Vanalinna P�evad jne.</span>
	</p>
	<p> <span style="font-family: tahoma, arial, helvetica, sans-serif;">
	Vabatahtlike klubi on avatud k�ikidele huvilistele, 
	kuid eelk�ige Kesklinna noortekeskuse sihtr�hmale, 
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
 

	<a href="?logout=1">Logi v�lja</a>
</p>



