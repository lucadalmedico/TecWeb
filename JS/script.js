"use strict";

function controlloErrori(){
	var risultato = true;

	//Check Nickname
	if(document.getElementById("nickname")){
		var input =document.getElementById("nickname").value;
		if(input == ""){
			document.getElementById("NicknameError").innerHTML =
														"Campo obbligatorio";
			risultato = false;
		}
		else if(input.length < 4 || input.length > 12){
			document.getElementById("NicknameError").innerHTML =
					"Il nickname deve essere compreso tra i 4 e i 12 caratteri";
			risultato = false;
		}
		else {
			document.getElementById("NicknameError").innerHTML = "";
		}
	}

	//Check Nome
	if(document.getElementById("nome")){
		var input =document.getElementById("nome").value;
		if(input.length < 3){
			document.getElementById("NomeError").innerHTML =
				"Il nome deve contenere almeno 3 caratteri";
			risultato = false;
		}
		else if (!(/^[a-zA-Z]+$/.test(input))){
			document.getElementById("NomeError").innerHTML =
				"Il nome puo avere solo lettere e spazi";
			risultato = false;
		}
		else {
			document.getElementById("NomeError").innerHTML = "";
		}
	}
	//Check Cognome
	if(document.getElementById("cognome")){
		var input =document.getElementById("cognome").value;
		if(input == ""){
			document.getElementById("CognomeError").innerHTML =
														"Campo obbligatorio";
			risultato = false;
		}
		else if (!(/^[a-zA-Z ]+$/.test(input))){
			document.getElementById("CognomeError").innerHTML =
									"Il cognome puo avere solo lettere e spazi";
			risultato = false;
		}
		else {
			document.getElementById("CognomeError").innerHTML = "";
		}
	}

	//Check Nome in Amministrazione
	if(document.getElementById("nomeAmm")){

		var input =document.getElementById("nomeAmm").value;
		document.getElementById("NomeError").innerHTML = campoNonVuoto(input);
		if(input == "")
			risultato = false;
	}

	//Check Cognome in Amministrazione
	if(document.getElementById("cognomeAmm")){

		var input =document.getElementById("cognomeAmm").value;
		document.getElementById("CognomeError").innerHTML = campoNonVuoto(input);
		if(input == "")
    		risultato = false;
	}

	//Check Email
	if(document.getElementById("email")){
		var input =document.getElementById("email").value;
		if(input == ""){
			document.getElementById("EmailError").innerHTML =
														"Campo obbligatorio";
			risultato = false;
		}
		else if(input == "admin" || input == "user"){
			document.getElementById("EmailError").innerHTML = "";
		}
		else if(!(/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/.test(input))){
			document.getElementById("EmailError").innerHTML =
															"Mail non corretta";
			risultato = false;
		}
		else {
			document.getElementById("EmailError").innerHTML = "";
		}
	}
	//Check Data
	if(document.getElementById("data")){
		var input =document.getElementById("data").value;
		if(input == ""){
			document.getElementById("DataError").innerHTML =
														"Campo obbligatorio";
			risultato = false;
		}
		else if(!(/[0-9]{2}[-,/,.]{1}[0-9]{2}[-,/,.]{1}[0-9]{2}([0-9]{2})?/.test(input))){
			document.getElementById("DataError").innerHTML =
														"Formato non corretto";
			risultato = false;
		}
		else document.getElementById("DataError").innerHTML = "";
	}
	//Check Password
	if(document.getElementById("password")){
		var input =document.getElementById("password").value;
		if(input == ""){
			document.getElementById("PasswordError").innerHTML =
														"Campo obbligatorio";
			risultato = false;
		}
		else if(input == "admin" || input == "user"){
			document.getElementById("PasswordError").innerHTML = "";
		}
		else if (!(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(input))){
			document.getElementById("PasswordError").innerHTML =
							"La password deve essere luna almeno 8 caratteri "+
							"e deve contenere almeno una lettera minuscola," +
							" una maiuscola e un numero";
			risultato = false;
		}
		else {
			document.getElementById("PasswordError").innerHTML = "";
		}
	}
	//Check ISBN
	if(document.getElementById("isbn")){
		var input =document.getElementById("isbn").value;
		if(input == ""){
			document.getElementById("ISBNError").innerHTML =
														"Campo obbligatorio";
			risultato = false;
		}
		else if (input.length != 13 || !(/[0-9]{13}/.test(input))){
			document.getElementById("ISBNError").innerHTML =
							"Il campo deve contenere 13 caratteri numerici";
			risultato = false;
		}
		else {
			document.getElementById("ISBNError").innerHTML = "";
		}
	}
	//Check Testo
	if(document.getElementById("testo")){

		var input =document.getElementById("testo").value;
		document.getElementById("TestoError").innerHTML = campoNonVuoto(input);
		if(input == "")
    		risultato = false;
	}
	//Check Casa editrice
	if(document.getElementById("casa")){
		var input =document.getElementById("casa").value;
		document.getElementById("CasaError").innerHTML = campoNonVuoto(input);
		if(input == "")
    		risultato = false;
	}
	//Check Titolo
	if(document.getElementById("titolo")){
		var input =document.getElementById("titolo").value;
		document.getElementById("TitoloError").innerHTML = campoNonVuoto(input);
		if(input == "")
    		risultato = false;
	}
	//Check Nazionalità
	if(document.getElementById("nazionalita")){
		var input =document.getElementById("nazionalita").value;
		document.getElementById("NazioneError").innerHTML = campoNonVuoto(input);
		if(input == "")
    		risultato = false;
	}
	//Check Lista libri amministrazione recensioni
	if(document.getElementById("isbnList")){

		var input =document.getElementById("isbnList");
		var option = input.options[input.selectedIndex].value;
		if(option == "none"){
			risultato = false;
		}
	}

	return risultato;
}

function campoNonVuoto(campo){
	var ritorno;
	if(campo == "")
		ritorno = "Campo obbligatorio";
	else
		ritorno = "";
	return ritorno;
}
