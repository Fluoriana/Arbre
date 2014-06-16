                                                                       /*     BASE DE DONNEES IMOSOWEB    */
/* */
CREATE DATABASE Imosoweb;

CREATE TABLE Utilisateur(
	id_user INTEGER PRIMARY KEY,
	login VARCHAR(50), 
	mdp VARCHAR(50),
	type INTEGER NOT NULL
); 

CREATE TABLE Client(
	id_client INTEGER PRIMARY KEY, 
	nom VARCHAR(50) NOT NULL, 
	prenom VARCHAR(50), 
	adresse_client VARCHAR(200), 
	cp_client INTEGER NOT NULL, 
	ville_client VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL, 
	statut INTEGER NOT NULL, 
	CONSTRAINT fk_id_client_user FOREIGN KEY (id_client) REFERENCES Utilisateur 
); 

CREATE TABLE Bien(
	id_bien INTEGER PRIMARY KEY, 
	adresse_bien VARCHAR(200) NOT NULL, 
	cp_bien INTEGER NOT NULL, 
	ville_bien VARCHAR(100) NOT NULL, 
	surface INTEGER NOT NULL, 
	surface_terrain INTEGER, 
	type_bien INTEGER,
	id_proprietaire INTEGER,
	CONSTRAINT fk_client_bien FOREIGN KEY (id_proprietaire) REFERENCES Client
);

CREATE TABLE Devis(
	id_devis INTEGER PRIMARY KEY, 
	id_client_devis INTEGER, 
	id_bien_devis INTEGER, 
	montantHT INTEGER NOT NULL, 
	TVA FLOAT(3) NOT NULL, 
	date_devis date NOT NULL,
	prix_carre_devis INTEGER NOT NULL, 
	rabais_devis INTEGER,
	CONSTRAINT fk_devis_client FOREIGN KEY (id_client_devis) REFERENCES Client,
	CONSTRAINT fk_devis_bien FOREIGN KEY (id_bien_devis) REFERENCES Bien 
);

CREATE TABLE Facture(
	id_facture INTEGER PRIMARY KEY, 
	id_client_facture INTEGER, 
	id_bien_facture INTEGER, 
	prixHT INTEGER NOT NULL, 
	TVA FLOAT(3) NOT NULL, 
	etat INTEGER NOT NULL, 
	date_emission date NOT NULL, 
	prix_carre_facture INTEGER, 
	rabais_facture INTEGER,
	CONSTRAINT fk_facture_client FOREIGN KEY (id_client_facture) REFERENCES Client,
	CONSTRAINT fk_facture_bien FOREIGN KEY (id_bien_facture) REFERENCES Bien
); 

CREATE USER Imosoweb WITH PASSWORD '08082013';



