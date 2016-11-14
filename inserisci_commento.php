<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
	<title>Inserisci commento</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="Social network per topi di bibblioteca"/>
	<meta name="autor" content="Gruppo TW"/>
	<meta name="keywords" content="Libri,Social,Network"/>
	<meta name="robots" content="index"/>
	<meta name="viewport" content="width=device-width"/>
	<link rel="stylesheet" media="screen" href="screen.css" type="text/css" />
	<link rel="stylesheet" media="print" href="print.css" type="text/css" />
	<link rel="stylesheet" media="aural" href="screenreader.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (max-width:480px), only screen and (max-device-width:480px)" href="phone.css" type="text/css" />
	<link rel="stylesheet" media="handheld, screen and (min-width:480px) and (max-width:1024px), only screen and (min-width:480px) and (max-device-width:1024px)" href="tablet.css" type="text/css" />
</head>
<body>
<?php

include('connect.php');

$id= $_POST['id'];
$libro= $_POST['libro'];
$autore= $_POST['autore'];
$genere= $_POST['genere'];
$data= $_POST['data'];
$casa= $_POST['casa'];
$scrittore= $_POST['scrittore'];

if (($id=="") or ($libro=="") or ($autore=="") or ($data=="") or ($testo="") or ($valutazione="")) 
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


