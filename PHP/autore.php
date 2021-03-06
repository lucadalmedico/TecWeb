<?php

	Require_once('connect.php');
	if(isset($_REQUEST['autore']) &&
		($datiArray = $db->query("SELECT Nome,Cognome,Data_Nascita,
			Nazionalita, Foto, Testo FROM DescrizioneAutore JOIN Scrittore On
			(DescrizioneAutore.Autore = Id) JOIN FotoAutori ON
			(FotoAutori.Autore =Id) WHERE Id = ". $_REQUEST['autore'])
		)) {

		Require_once('functions.php');
		if($datiArray->num_rows > 0){
			$dati = $datiArray->fetch_array(MYSQLI_ASSOC);

			$searchHead=array("{{title}}","{{description}}");
			$replaceHead=array($dati['Cognome']. " - ",
				"Pagina di ". $dati['Nome']. " ". $dati['Cognome'].
				" su FaceOnTheBook");
			echo str_replace($searchHead ,$replaceHead,
				file_get_contents("../HTML/Template/Head.txt"));


			echo menu();

			$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
			$replaceBreadcrumb=array("","<span xml:lang='en'>
				<a href='index.php'>Home</a></span> &gt; "
				. $dati['Cognome']. " ". $dati['Nome']);
			echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
				file_get_contents("../HTML/Template/Breadcrumb.txt"));

			//Stampo le informazioni dell' autore
			$searchHeader=array("{{Immagine}}","{{Cognome}}","{{Nome}}",
				"{{Data}}","{{Nazionalita}}");
			$replaceHeader=array($dati['Foto'],$dati['Cognome'], $dati['Nome'],
				Data($dati['Data_Nascita']),$dati['Nazionalita']);
			echo str_replace($searchHeader ,$replaceHeader,
				file_get_contents("../HTML/Template/IntestazioneAutore.txt")).

			file_get_contents("../HTML/Template/LinkAlMenu.txt").

			"<div id='DescrizioneAutore'>".
					$dati['Testo']. "</div>";

			//Ricerca di tutti i libri dell' autore nel sito
			if($AltriLibri = $db->query("SELECT Titolo,ISBN,Anno_Pubblicazione
				FROM Libro WHERE Autore ='". $_REQUEST['autore'].
				"' ORDER BY Anno_Pubblicazione")) {

				echo "<div class='info'>
				<h2>Libri di ". $dati['Cognome']. " presenti nel sito: </h2>
				<ul>";

				while($row = $AltriLibri->fetch_array(MYSQLI_ASSOC)){
					echo "<li><a href='libro.php?libro=". $row['ISBN']. "'>".
					$row['Titolo'] . "</a></li>";
				}
			echo "</ul>
			</div>";//fine classe info

			$AltriLibri->free();
			}


			echo "</div>".//fine class text
			file_get_contents("../HTML/Template/LinkAlMenu.txt").
			"</div>".//fine class content

			file_get_contents("../HTML/Template/Footer.txt");
		}
	$datiArray->free();
	$db->close();
	}
	else {
		header("Location: page_not_found.php");
	}
	exit;
?>
