<?php
	if(!isset($_SESSION))
		session_start();
	if(isset($_SESSION['type']) && $_SESSION['type'] == "admin"){
		Require_once('connect.php');
		Require_once('functions.php');

		if(isset($_POST['delete'])){
			$delete = "DELETE FROM `Utente` WHERE `Email` = '". $_POST['delete']. "'";
			$db->query($delete);
		}

		$errore=false;

		$searchInForm=array("{{Titolo}}","{{Pagina}}","{{nickError}}","{{emailError}}",
			 "{{nomeError}}", "{{cognomeError}}","{{dateError}}", "{{passError}}"
		 	,"{{AggiungiClassi}}");
		$replaceInForm=array("Inserisci utente","amministrazioneUtenti.php"
			,testNick($errore), testEmail($errore), testNome($errore)
			, testCognome($errore), testDate($errore), testPassword($errore),"");

		if(!$errore && isset($_POST['email']) && isset($_POST['nome']) &&
			isset($_POST['cognome'])	&& isset($_POST['nickname']) &&
			isset($_POST['password']))
		{
			$ENC_password=password_hash($_POST['password'], PASSWORD_BCRYPT );

			$insert="INSERT INTO `Utente`(Email, Nome, Cognome, Nickname
				, Password) VALUES ('".$_POST['email']."','".$_POST['nome']."','".
					$_POST['cognome']."','".$_POST['nickname']. "','". $ENC_password. "')";
			$db->query($insert);
		}

		$searchHead=array("{{title}}","{{description}}");
		$replaceHead=array("Amministrazione Utenti - ",
			"Pagina per la gestione degli utenti su FaceOnTheBook");

		echo str_replace($searchHead ,$replaceHead,
		 	file_get_contents("../HTML/Template/Head.txt"));

		echo menu();

		$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
		$replaceBreadcrumb=array("","<span xml:lang='en'> <a href='index.php'>Home</a>
			</span> &gt; <span><a href='amministrazione.php'>Amministrazione</a>
			</span> &gt; Utenti");
		echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		 	file_get_contents("../HTML/Template/Breadcrumb.txt")).

		"<div class='centrato content'>
		<a name = 'top'></a>
		<a href = '#insert' class = 'adminButton'>&#43;&nbsp;Nuovo Utente</a>";

		if($Utenti = $db->query("SELECT * FROM Utente ORDER BY Cognome")){
			echo file_get_contents("../HTML/Template/InizioTabellaUtente.txt");
			while ($Utente = $Utenti->fetch_array(MYSQLI_ASSOC)){

				$search=array("{{Email}}","{{Cognome}}","{{Nome}}","{{Nickname}}",
								"{{Id}}");
				$replace=array($Utente['Email'],$Utente['Cognome'],$Utente['Nome'],
					$Utente['Nickname'],str_replace("@","",$Utente['Email']));
				echo str_replace($search ,$replace,
					file_get_contents("../HTML/Template/TabellaUtente.txt"));
			}
			$Utenti->free();
		}
		echo "</tbody></table></div>".

		file_get_contents("../HTML/Template/LinkAlMenu.txt").

		//Form inserimento
		"<a name = 'insert'></a>
		<a href='#top' class = 'adminButton'>Torna all' elelnco</a>".

		str_replace($searchInForm, $replaceInForm ,
			file_get_contents("../HTML/Template/RegForm.txt"));

		$db->close();

		echo "</div>".//Fine content
		file_get_contents("../HTML/Template/FileJs.txt").
		file_get_contents("../HTML/Template/Footer.txt");
	}
	else{
		header("Location: page_not_found.php");
		exit();
	}
?>
