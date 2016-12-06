<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
	<title>Inserisci recensione</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="Social network per topi di bibblioteca"/>
	<meta name="autor" content="Gruppo TW"/>
	<meta name="keywords" content="Libri,Social,Network"/>
	<meta name="robots" content="index"/>
	<meta name="viewport" content="width=device-width"/>
	<link rel="stylesheet" media="print" href="print.css" type="text/css" />
	<link rel="stylesheet" media="aural" href="screenreader.css" type="text/css" />
	<link rel="stylesheet" media="screen" href="screen.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (min-width:1200px) , only screen and (min-width:1200px)" href="bigScreen.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (max-width:1024px), only screen and (max-device-width:1024px)" href="tabletLandscape.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (max-width:768px), only screen and (max-device-width:768px)" href="tabletPortrait.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (max-width:600px), only screen and (max-device-width:600px)" href="phoneLandscape.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (max-width:480px), only screen and (max-device-width:480px)" href="phonePortrait.css" type="text/css" />
	
	
	
	
</head>
<body>
	<div class="menu" id="menu"> <!-- Barra di navigazione -->
		<ul>
		<li class="icona"><a onclick="mobileMenu()">&#9776;</a></li>
		<li id="Accesso" class="right"><a href="index.html">Accedi</a>
				<div id="Dropdown">
						<form action="submission.php" method="post">
							<fieldset class="textBox">
								<label for="username_input">E-mail</label>
								<input type="text" id="username_input"/>
								<label for="username_psw">Password</label>
								<input type="password" id="username_psw" />
								<input type="submit" value="Accedi" id="btnAccedi" />
								<a href="" id="forgot"> <span>Password dimenticata?</span></a>
							</fieldset>
						</form>
				</div>
			</li>
			<li class="right"><a href="index.html">Iscriviti</a></li>				
			<li><a href="index.html" xml:lang="en">Home</a></li>
			<li><a href="index.html" xml:lang="en">News</a></li>
			<li><a href="index.html">Recensioni</a></li>
			<li><a href="index.html">Classifica</a></li>
			<li><a href="contacts.html">Contatti</a></li>	
		</ul>
	</div>
	
	<div class="breadcrumb">
		<p class="path">Ti trovi in: <span xml:lang="en"><a href="index.html">Home</a></span>/<a href="amministrazione.html">Amministrazione </a>/<a href="recensione.html">Recensione</a>/Inserisci recensione</p>
		<div class="searchform">
			<form action="action_page.php">
				<fieldset>
					<input type="text" name="googlesearch" id="search" />
					<input type="submit" value="Cerca"/>
				</fieldset>
			</form>
		</div> 
	</div>
<?php

include('connect.php');

$codice= $_POST['codice'];
$libro= $_POST['libro'];
$autore= $_POST['autore'];
$testo= $_POST['testo'];
$data= $_POST['data'];
$valutazione= $_POST['valutazione'];

if (($codice=="") or ($libro=="") or ($autore=="") or ($data=="") or ($testo="") or ($valutazione="")) 
{ 
echo "<br><h1>Errore, dati mancanti</h1>";
} 
else

{
if (!(mysqli_stmt_num_rows(mysqli_multi_query($db,"SELECT * FROM `libro` WHERE isbn='$libro'"))))
{echo '<br><h1>Libro non presente';}
else{
$insert="INSERT INTO `recensione` VALUES ('$id','$libro','$autore','$data','$testo', '$valutazione')";

} 
} 
$result = mysqli_multi_query($db,$insert);

if($result){
	echo("<br> <H1>Inserimento avvenuto correttamente</H1>");
} else{
	echo("<br><H1>Inserimento non eseguito</h1>");
} 
?>
</body>
</html>

