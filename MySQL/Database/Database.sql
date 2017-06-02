SET foreign_key_checks = 0;

/* PULIZIA DATABASE */

DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Scrittore;
DROP TABLE IF EXISTS Libro;
DROP TABLE IF EXISTS Recensione;
DROP TABLE IF EXISTS Redazione;
DROP TABLE IF EXISTS Commenti;
DROP TABLE IF EXISTS VotoRecensione;
DROP TABLE IF EXISTS VotoLibro;
DROP TABLE IF EXISTS Notizie;
DROP TABLE IF EXISTS FotoAutori;
DROP TABLE IF EXISTS DescrizioneAutore;

/* TABELLE */

CREATE TABLE Utente
(	Email	varchar (60) PRIMARY KEY,
	Nome	varchar(30) NOT NULL,
	Cognome	varchar(30) NOT NULL,
	Nickname	varchar(30) UNIQUE NOT NULL,
	Data_Nascita	date,	
	Password varchar(255) NOT NULL,
	Residenza	varchar(30) 
);

CREATE TABLE Scrittore
(	Id  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Nome	varchar(30) NOT NULL,
	Cognome	varchar(30) NOT NULL,
	Data_Nascita	date NOT NULL,
	Nazionalita	varchar(30) NOT NULL
);

CREATE TABLE Libro
(	ISBN varchar(13) PRIMARY KEY,
	Titolo	varchar(80) NOT NULL,
	Autore	INT UNSIGNED NOT NULL,
	Anno_Pubblicazione	date NOT NULL,
	Casa_Editrice	varchar (40) NOT NULL,
	Genere enum('Commedia','Horror','Fantasy','Narrativa','Saggistica','Classico','Thriller','Fantascienza') NOT NULL,
	Trama text NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Scrittore(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Recensione
(	Id	INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Libro varchar(13) NOT NULL,
	Autore varchar(60) NOT NULL,
	Data_Pubblicazione	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	Valutazione  DECIMAL(2,1) NOT NULL,
	Testo	text NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Redazione(Email)
  	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Redazione
(	Email	varchar (60) PRIMARY KEY,
	Password varchar(255) NOT NULL,
	Nome	varchar(30) NOT NULL,
	Cognome	varchar(30) NOT NULL
);

CREATE TABLE Commenti
(	Recensione INT UNSIGNED,
	Autore varchar(60),
	Commento text(3000) NOT NULL,
	Data_Pubblicazione	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (Recensione, Autore, Data_Pubblicazione),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Recensione) REFERENCES Recensione(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE VotoRecensione
(	Recensione INT UNSIGNED,
	Autore varchar(60),
	Valutazione DECIMAL(2,1) NOT NULL,
	PRIMARY KEY (Recensione, Autore),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Recensione) REFERENCES Recensione(Id)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);
CREATE TABLE VotoLibro
(	Libro varchar(13),
	Autore varchar(60),
	Valutazione DECIMAL(2,1) NOT NULL,
	PRIMARY KEY (Libro, Autore),
	FOREIGN KEY (Autore) REFERENCES Utente(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (Libro) REFERENCES Libro(ISBN)
   	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE Notizie
(	Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	Titolo varchar(90) NOT NULL,
	Autore varchar(60) NOT NULL,
	Data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Testo text NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Redazione(Email)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE FotoAutori
(	Autore	INT UNSIGNED PRIMARY KEY,
	Foto varchar(60) NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Scrittore(Id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE DescrizioneAutore
(	Autore	INT UNSIGNED PRIMARY KEY,
	Testo text NOT NULL,
	FOREIGN KEY (Autore) REFERENCES Scrittore(Id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

SET foreign_key_checks = 1;
