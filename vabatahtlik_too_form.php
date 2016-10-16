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
    background-color: #94cfdd;
    clear: left;
    text-align: center;
}
</style>




<!DOCTYPE html>
<html>
<head>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #e7e7e7;
    background-color: #f3f3f3;
}

li {
    float: left;
}

li a {
    display: block;
    color: #666;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #ddd;
}

li a.active {
    color: white;
    background-color: #ddd;
}
</style>
</head>
<body>

<ul>
  <li><a href="avalehekülg.php">Avaleht</a></li>
  <li><a class="active" href="vabatahtlik_too_form.php">Lisa vabatahtlik töö</a></li>
  <li><a href="contact.php">Kontakt</a></li>
</ul>

</body>
</html>






<h2>Lisa vabatahtlik töö</h2>
<form method="POST">

<label>Ürituse nimi</label><br>
<input name="event_name" type=text>

<br><br>

<label> Sisestage ürituse kirjeldus</label><br>
<textarea name="evenr_descripition" cols="30" rows="5"></textarea>

<br><br>

<label> Toimumise aeg </label><br>
<input name="date_and_time" type=text>

<br><br>

<input type="submit" value="Salvesta">

</form>

<h2>Vabatahtlik töö</h2>
<?php

$html = "<table>";

$html .= "<tr>";
	$html .= "<th>id</th>";
	$html .= "<th>nimi</th>";
	$html .= "<th>kirjeldus</th>";
	$html .= "<th>aeg</th>";

$html .= "</tr>";


//iga liikme kohta massiivis
foreach($vabatahtlikData as $c){
	
	$html .= "<tr>";
	$html .= "<td>".$c->id."</td>";
	$html .= "<td>".$c->nimi."</td>";
	$html .= "<td>".$c->kirjeldus."</td>";
	$html .= "<td>".$c->aeg."</td>";
	

$html .= "</tr>";

	//iga töö on $c
	
	
}
$html .= "</table>";

echo $html;