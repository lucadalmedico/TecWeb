<?php
	Require_once('connect.php');
	Require_once('functions.php');

	//stampo l'head dell'html
	$replaceHead=array("Accedi a FaceOnTheBook", "Pagina di login");
	$searchHead=array("{{title}}","{{description}}");
	echo str_replace($searchHead ,$replaceHead, file_get_contents("../HTML/Template/Head.txt"));

	$errore = false;
	$wrongPassword = false;
	$user = false;
	$admin = false;

	if(isset($_POST['email']))
	//Controllo se l'utete é un amministratore o un utente e verifico la sua password
	{
		$UserPassQuery="SELECT Password FROM `Utente` WHERE Email='".mysqli_real_escape_string($db,$_POST['email'])."'";
		$AdminPassQuery="SELECT Password FROM `Redazione` WHERE Email='".mysqli_real_escape_string($db,$_POST['email'])."'";
		$password = "";
		//cerco tra gli utenti
		$gruppo = $db->query($UserPassQuery);
		if ( $gruppo->num_rows > 0){ //é un utente
			$user = true;
		}
		else{
			$gruppo = $db->query($AdminPassQuery);
			if ( $gruppo->num_rows > 0){ //é un admin
				$admin = true;
			}
		}
		if( $admin || $user ){
			$Getpassword = $gruppo->fetch_array(MYSQLI_ASSOC);
			$password = $Getpassword['Password'];
		}
		if($password != "" )
		//Controllo se la password é corretta
			$wrongPassword =  !(password_verify($_POST['password'],$password));

		$gruppo->free();
	}

	echo menu();

	$searchBreadcrumb=array("{{AggiungiClassi}}","{{Path}}");
	$replaceBreadcrumb=array("",
		"<span xml:lang='en'> <a href='index.php'>Home</a></span> &gt; Accedi");
	echo str_replace($searchBreadcrumb ,$replaceBreadcrumb,
		file_get_contents("../HTML/Template/Breadcrumb.txt"));


	//stampo il form del login
	$searchInForm=array("{{emailError}}","{{passError}}");
	$replaceInForm=array(testEmail($errore,true), testPassword($errore,$wrongPassword));
	echo str_replace($searchInForm, $replaceInForm ,
		 file_get_contents("../HTML/Template/login.txt"));

	if(!$errore && ($admin || $user ) && isset($_POST['password']) && isset($_POST['email']) )
	//se non ci sono errori avvio la sessione
	{
		session_start();

		//se la password in input è utente
		if( $user )
			$_SESSION['type'] = 'user';
		//se la password in input è admin
		else if( $admin )
			$_SESSION['type'] = 'admin';

		$_SESSION['id'] = $_POST['email'];
		$_SESSION['ultimaAttivita'] = time();

		header('Location: index.php');

	}


	echo file_get_contents("../HTML/Template/FileJs.txt");
	echo file_get_contents("../HTML/Template/Footer.txt");
?>
