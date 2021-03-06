<?php
	Require_once('connect.php');
	if(isset($_REQUEST['libro']) &&
		$datiLibro = $db->query("SELECT Foto,ISBN,Titolo, Anno_Pubblicazione,
		Casa_Editrice, Genere, Trama, Id, Nome, Cognome FROM FotoLibri JOIN
		Libro ON ( FotoLibri.Libro = Libro.ISBN) JOIN Scrittore ON
		(Libro.Autore = Scrittore.Id) WHERE Libro.ISBN = ".$_REQUEST['libro'])) {
		 if($datiLibro->num_rows > 0) {
		Require_once('functions.php');

		$datiRecensione = $db->query("SELECT Nome, Cognome, Id, Valutazione, Testo
				FROM Recensione JOIN Redazione ON (Redazione.Email =
				Recensione.Autore )	WHERE Libro = ".$_REQUEST['libro']);

		$datiRec = $datiRecensione->fetch_array(MYSQLI_ASSOC);

		$errore ="";
		$dati = $datiLibro->fetch_array(MYSQLI_ASSOC);

		if(!isset($_SESSION))
        	session_start();

		//Azioni form
		if(isset($_SESSION['id'])){
			//Inserimento commento
			if(isset($_POST['text']) && !$_POST['text']==""){
				$ntesto ="<p>". strip_tags(htmlentities($_POST['text'], ENT_QUOTES)). "</p>";
				$sql = "INSERT INTO Commenti (Libro,Autore,Commento)
						VALUES ('".$_REQUEST['libro']."','".$_SESSION['id']."','$ntesto')";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento commento</p>";
				}
			}
			//Eliminazione Commento
			else if(isset($_POST['deleteUser'])) {
				$sql = "DELETE FROM `Commenti` WHERE `Commenti`.`Libro` =
						".$_REQUEST['libro']." AND `Commenti`.`Autore` = '".$_POST['deleteUser']."'
						AND `Commenti`.`Data_Pubblicazione` = '".$_POST['deleteData']."'";

				if(!$db->query($sql)){
					$errore = "<p>Problema eliminazione commento</p>";
				}
			}
			//Voto libro
			else if(isset($_POST['valutazioneB'])){
				$clean ="DELETE FROM VotoLibro WHERE Autore = '".$_SESSION['id']."'
						AND Libro = ".$_REQUEST['libro'];
				$db->query($clean);
				$sql = "INSERT INTO VotoLibro (Libro,Autore,Valutazione)
						VALUES (".$_REQUEST['libro'].",'".$_SESSION['id'].
						"','".$_POST['valutazioneB']."');";

				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento voto</p>";
				}
			}
			//Voto recensione
			else if(isset($_POST['valutazioneRec'])){
				$clean ="DELETE FROM VotoRecensione WHERE Autore = '".$_SESSION['id']."'
						AND Recensione = ".$datiRec['Id'];
				$db->query($clean);
				$sql = "INSERT INTO VotoRecensione (Recensione,Autore,Valutazione)
						VALUES (".$datiRec['Id'].",'".$_SESSION['id']."','".
						$_POST['valutazioneRec']."');";
				if(!$db->query($sql)){
					$errore = "<p>Problema inserimento voto</p>";
				}
			}
		}//Fine azioni form



			$searchHead=array("{{title}}","{{description}}");
			$replaceHead=array(strip_tags($dati['Titolo']). " - "
				,"Recensione di '". strip_tags($dati['Titolo']). "' su FaceOnTheBook");
			echo str_replace($searchHead ,$replaceHead,
							 file_get_contents("../HTML/Template/Head.txt"));

			echo menu();


			$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
			$replaceBreadcrumb=array(""
						,"<span xml:lang='en'><a href='index.php'>Home</a></span> &gt; <span>
						<a href='recensioni.php'>Recensioni</a>
						</span> &gt; ". $dati['Titolo']);
			echo str_replace($searchBreadcrumb ,$replaceBreadcrumb
						, file_get_contents("../HTML/Template/Breadcrumb.txt"));

			$searchHeader=array("{{errore}}","{{ISBN}}","{{Titolo}}","{{Id}}",
				"{{Nome}}","{{Cognome}}","{{Casa}}","{{Genere}}","{{Data}}","{{Img}}");
			$replaceHeader=array($errore,$dati['ISBN'],$dati['Titolo'],
				$dati['Id'],$dati['Nome'],$dati['Cognome']
				,$dati['Casa_Editrice'],$dati['Genere']
				,Data($dati['Anno_Pubblicazione']),$dati['Foto']);
			echo str_replace($searchHeader ,$replaceHeader,
				file_get_contents("../HTML/Template/IntestazioneLibro.txt"));

		}
		if($datiRec) { //Stampa della recensione e dei suoi dati

			//Voto al libro dato dalla redazione

			echo "<ul class='valutazioniRecensione'>
				<li>Voto della redazione: <div class='stelle'>".
				printStar($datiRec['Valutazione']). "</div></li>";

			}
			//Voto al libro dato dalla media dei voti al libro degli utenti
			if($votoLibArray = $db->query("SELECT ROUND(AVG(Valutazione),1) AS Media
											FROM VotoLibro GROUP BY (Libro)
											HAVING Libro = ".$_REQUEST['libro'])){
				if($votoLibArray->num_rows>0){
					$votoLib = $votoLibArray->fetch_array(MYSQLI_ASSOC);
					echo "<li>Voto degli utenti: <div class='stelle'>".
						printStar($votoLib['Media']). "</div></li>";
				}
				$votoLibArray->free();
			}

			//Voto alla recensione dato dalla media dei voti alla recensione degli utenti
			if($votoRecArray = $db->query("SELECT ROUND(AVG(Valutazione),1) AS Media
											FROM VotoRecensione GROUP BY (Recensione)
											HAVING Recensione ='".$datiRec['Id']."'")){
				if($votoRecArray->num_rows>0){
					$votoRec = $votoRecArray->fetch_array(MYSQLI_ASSOC);
					echo "<li>Voto alla recensione: <div class='stelle'>".
						printStar($votoRec['Media']). "</div></li>";
				}
				$votoRecArray->free();

		if($datiRec) {
			echo "</ul><h2>Recensione scritta da ".$datiRec['Nome']. " ".
				$datiRec['Cognome']. "</h2>".
				file_get_contents("../HTML/Template/LinkAlMenu.txt");
		}

		} // FINE  voti recensione


		echo "</div><div class='text sotto'><h2>Trama: </h2>".
		$dati['Trama'].
		file_get_contents("../HTML/Template/LinkAlMenu.txt");
		if($datiRec){
			echo "<h2>Recensione:</h2>".
			$datiRec['Testo'];
			echo file_get_contents("../HTML/Template/LinkAlMenu.txt");
		}




		// SEZIONE COMMENTI

		if ($datiCommenti = $db->query("SELECT Commento,Nickname,Data_Pubblicazione
			 	,Autore FROM Commenti Join Utente ON
				(Utente.Email = Commenti.Autore) WHERE Libro =
										".$_REQUEST['libro']."
										ORDER BY Data_Pubblicazione DESC")) {
			if($datiCommenti->num_rows>0) {
				echo "<h2>Commenti</h2>
					<div class='comments'>";
					$id = 0;
				while ($Commento = $datiCommenti->fetch_array(MYSQLI_ASSOC)) {

					echo "<div class = 'comment'>
					<div class = 'commentTitle'>";

					//Form eliminazione commento
					//Gli unici che possono cancellare un commento solo
					//l'autore del commento oppure un amministratore
					if(isset($_SESSION['type']) && ($Commento['Autore'] == $_SESSION['id']
						|| $_SESSION['type'] == 'admin' )) {
						$searchDeleteCommento=array("{{codice}}","{{Autore}}", "{{Data}}",
							"{{IdCommento}}");
						$replaceDeleteCommento=array($_REQUEST['libro'],$Commento['Autore'],
						 	$Commento['Data_Pubblicazione'],$id);
						echo str_replace($searchDeleteCommento ,
							$replaceDeleteCommento,
							file_get_contents("../HTML/Template/DeleteLibro.txt"));
					}

					$searchCommento=array("{{Username}}","{{Data}}", "{{Testo}}");
					$replaceCommento=array($Commento['Nickname'],
						Data($Commento['Data_Pubblicazione'],true),
						$Commento['Commento']);
					echo str_replace($searchCommento ,$replaceCommento,
						file_get_contents("../HTML/Template/CommentoLibro.txt"));
					$id += 1;
				} //Fine ciclo

			echo "</div>".// Fine class comments

			file_get_contents("../HTML/Template/LinkAlMenu.txt");
			}
		$datiCommenti->free();
		}

		//Form inserimento commenti (solo per un utente loggato)

		if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
			$searchNuovoCommento=array("{{codice}}");
			$replaceNuovoCommento=array($_REQUEST['libro']);
			echo str_replace($searchNuovoCommento ,$replaceNuovoCommento
						, file_get_contents("../HTML/Template/AddCommento.txt")).
			file_get_contents("../HTML/Template/LinkAlMenu.txt");
		}

		echo "</div>"; // Fine class text



		//Voti dell' utente loggato al libro o alla recensione

		if(isset($_SESSION['type']) &&  $_SESSION['type'] == 'user'){
			//Voto al libro
			$searchVotaLibro=array("{{codice}}","{{titolo}}", "{{id}}");
			$replaceVotaLibro=array($_REQUEST['libro'],"Vota il libro!", "valutazioneB");
			echo str_replace($searchVotaLibro ,$replaceVotaLibro
						, file_get_contents("../HTML/Template/VotoLibro.txt"));

			//Voto alla recensione
			if($datiRec) {
				$searchVotaRec=array("{{codice}}","{{titolo}}", "{{id}}");
				$replaceVotaRec=array($_REQUEST['libro'],"Vota la recensione!",
					"valutazioneRec");
				echo str_replace($searchVotaRec ,$replaceVotaRec
						, file_get_contents("../HTML/Template/VotoLibro.txt"));
			}
			echo file_get_contents("../HTML/Template/LinkAlMenu.txt");
		} //Fine voti libro/recensione

		echo "</div>". //Fine classe content
		file_get_contents("../HTML/Template/Footer.txt");
		$datiLibro->free();
		$datiRecensione->free();
		$db->close();

	} //end if(isset($_REQUEST['libro']) && !$datiLibro)
	else {
		header("Location: page_not_found.php");
		exit();
	}
?>
