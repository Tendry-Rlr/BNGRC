-- Villes, Regions, Dons, Besoins, Besoin_Type

CREATE DATABASE BNGRC;
USE BNGRC;

CREATE OR REPLACE TABLE Region(
    id_Region int primary key auto_increment,
    nom_Region varchar(50)
);

CREATE OR REPLACE TABLE Ville(
    id_Ville int primary key auto_increment,
    id_Region int references Region(id_Region),
    nom_Ville varchar(50)
);

CREATE OR REPLACE TABLE Besoin_Categorie(
    id_Besoin_Categorie int primary key auto_increment,z
    libelle varchar(50)
);

CREATE OR REPLACE TABLE Besoin_Fille(
    id_Besoin_Fille int primary key auto_increment,
    id_Besoin_Categorie int references Besoin_Categorie(id_Besoin_Categorie),
    prix_Unitaire double
);

CREATE OR REPLACE TABLE Besoin(
    id_Besoin int primary key auto_increment,
    id_Ville int references Ville(id_Ville),
    id_Besoin_Fille int references Besoin_Fille(id_Besoin_Fille),
    quantite double,
    nom_Besoin varchar(50) 
);

CREATE OR REPLACE TABLE Don(
    id_Don int primary key auto_increment,
    id_Ville int references Ville(id_Ville),
    id_Besoin_Fille int references Besoin_Fille(id_Besoin_Fille),
    quantite double,
    date_Dispatch date
);

create or replace table Achat_Attente(
    id_Achat_Attente int primary key auto_increment,
    id_Ville int references Ville(id_Ville),
    id_Besoin int REFERENCES Besoin(id_Besoin),
    quantite DOUBLE, 
    date_dispatch date,
    prix double
);


select * from Achat_Attente;