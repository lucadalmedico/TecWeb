<?php
	Require_once('connect.php');
	Require_once('functions.php');

	$searchHead=array("{{title}}","{{description}}");
	$replaceHead=array("",
		"Social network per topi di bibblioteca");
	echo str_replace($searchHead ,$replaceHead,
		file_get_contents("../HTML/Template/Head.txt"));

	echo menu().

	file_get_contents("../HTML/Template/IndexHeader.txt");

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("attacca","<span xml:lang='en'>Home</span>");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		file_get_contents("../HTML/Template/Breadcrumb.txt")).
	"<div class='centrato content'>
	<div class='elenco marginMobile'>

	<dl class='leftBig'>
	<dt>Ultime Recensioni</dt>
	";
	//ULTIME RECENSIONI
	if($UltimeRec = $db->query("SELECT Foto,Libro.ISBN, Libro.Titolo, Libro.Trama,
		Recensione.Testo, Recensione.Data_Pubblicazione FROM FotoLibri JOIN
		Libro ON (FotoLibri.Libro = Libro.ISBN) JOIN
		Recensione ON(Recensione.Libro = Libro.ISBN)
		ORDER BY Recensione.Data_Pubblicazione DESC LIMIT 5")){
		if($UltimeRec->num_rows > 0){
			while($row = $UltimeRec->fetch_array(MYSQLI_ASSOC)){
				$searchLibro=array("{{ISBN}}","{{Titolo}}","{{Testo}}","{{Img}}");
				$replaceLibro=array($row['ISBN'],$row['Titolo'],
					ReadMore($row['Testo']),$row['Foto']);
				echo str_replace($searchLibro ,$replaceLibro,
					file_get_contents("../HTML/Template/MiniaturaLibro.txt"));
			}
		}
		$UltimeRec->free();
	}
	//Fine ultime recensioni
	echo "</dl>".

	file_get_contents("../HTML/Template/LinkAlMenu.txt").

	"<div class='rightSmall'>

	<h2>Ultime uscite</h2>";
	//ULTIMI LIBRI USCITI
	if($UltimeExt = $db->query("SELECT ISBN, Titolo, Trama FROM Libro
		ORDER BY Anno_Pubblicazione DESC LIMIT 11")){
		if($UltimeExt->num_rows > 0){
			echo "<ul>";
			while($rowE = $UltimeExt->fetch_array(MYSQLI_ASSOC)){
				echo "<li><a href='libro.php?libro=". $rowE['ISBN']. "'>".
					$rowE['Titolo']. "</a></li>
				";
			}
			echo "</ul>";
		}
		$UltimeExt->free();
	}
	// Fine ultime uscite
	echo "</div>". file_get_contents("../HTML/Template/LinkAlMenu.txt").

	"<div class='rightSmall'>

	<h2><span xml:lang='en'>News</span></h2>";
	//ULTIME NOTIZIE

	if ($UltimeNews = $db->query("SELECT * FROM Notizie
		ORDER BY Data DESC LIMIT 4")) {
		if($UltimeNews->num_rows>0) {
			echo "<ul>";
			while ($rowNews = $UltimeNews->fetch_array(MYSQLI_ASSOC)) {
				echo "<li><a href='notizia.php?news=". $rowNews['Id']. "'>".
					$rowNews['Titolo']. "</a></li>";
			}
			echo "</ul>";
		}
		$UltimeNews->free();
	}

	$db->close();

	echo "</div>". //Fine Ultime news
	file_get_contents("../HTML/Template/LinkAlMenu.txt").
	"</div>
	</div>".
	//Fine classe elenco
	//Fine classe content
	file_get_contents("../HTML/Template/Footer.txt");
?>
