<?php

	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("<title>Amministrazione Redazione - FaceOnTheBook </title>","<meta name='description' content='Social network per topi di bibblioteca'/>");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a></span>/<span> <a href='amministrazione.php'>Amministrazione</a></span>/Redazione");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb, file_get_contents("../HTML/Template/Breadcrumb.txt"));

	echo "<div class='centrato content'>";
	echo "<a href='#insert' id = 'new'>&#43;&nbsp;Nuovo Amministratore</a>";

	if($Amministratori = $db->query("SELECT * FROM Redazione ORDER BY Cognome")){
		echo file_get_contents("../HTML/Template/InizioTabellaRedazione.txt");
		while ($Admin = $Amministratori->fetch_array(MYSQLI_ASSOC)){
			$search=array("{{Email}}","{{Nome}}","{{Cognome}}");
			$replace=array($Admin['Email'],$Admin['Nome'],$Admin['Cognome']);
			echo str_replace($search,$replace, file_get_contents("../HTML/Template/Tabellaedazione.txt"));
		}
		$Amministratori->free();
	}
	echo "</tbody></table></div>";

	//Form inserimento in redazione
	echo file_get_contents("../HTML/Template/FormInserimentoRedazione.txt");

	$db->close();

	echo "</div>";//Fine content

	echo file_get_contents("../HTML/Template/Footer.txt");

?>