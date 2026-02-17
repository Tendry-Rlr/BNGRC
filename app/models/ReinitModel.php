<?php

namespace app\models;

use Flight;
use PDO;

class ReinitModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function reinit(){
        $sql = "
        SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Region;
CREATE TABLE Region(
    id_Region int primary key auto_increment,
    nom_Region varchar(50)
);

DROP TABLE IF EXISTS Ville;
CREATE TABLE Ville(
    id_Ville int primary key auto_increment,
    id_Region int references Region(id_Region),
    nom_Ville varchar(50)
);

DROP TABLE IF EXISTS Besoin_Categorie;
CREATE TABLE Besoin_Categorie(
    id_Besoin_Categorie int primary key auto_increment,
    libelle varchar(50)
);

DROP TABLE IF EXISTS Besoin_Fille;
CREATE TABLE Besoin_Fille(
    id_Besoin_Fille int primary key auto_increment,
    id_Besoin_Categorie int references Besoin_Categorie(id_Besoin_Categorie),
    prix_Unitaire double
);

DROP TABLE IF EXISTS Besoin;
CREATE TABLE Besoin(
    id_Besoin int primary key auto_increment,
    id_Ville int references Ville(id_Ville),
    id_Besoin_Fille int references Besoin_Fille(id_Besoin_Fille),
    quantite double,
    nom_Besoin varchar(50) 
);

DROP TABLE IF EXISTS Don;
CREATE TABLE Don(
    id_Don int primary key auto_increment,
    id_Ville int references Ville(id_Ville),
    id_Besoin_Fille int references Besoin_Fille(id_Besoin_Fille),
    quantite double,
    date_Dispatch date
);

DROP TABLE IF EXISTS Achat_Attente;
CREATE TABLE Achat_Attente(
    id_Achat_Attente int primary key auto_increment,
    id_Ville int references Ville(id_Ville),
    id_Besoin int REFERENCES Besoin(id_Besoin),
    quantite DOUBLE, 
    date_dispatch date,
    prix double
);

SET FOREIGN_KEY_CHECKS = 1;

-- Donnees de test
INSERT INTO Region (id_Region, nom_Region) VALUES
    (1, 'Nord'),
    (2, 'Sud'),
    (3, 'Est');

INSERT INTO Ville (id_Ville, id_Region, nom_Ville) VALUES
    (1, 1, 'Ville A'),
    (2, 1, 'Ville B'),
    (3, 2, 'Ville C'),
    (4, 3, 'Ville D');

INSERT INTO Besoin_Categorie (id_Besoin_Categorie, libelle) VALUES
    (1, 'Nature'), 
    (2, 'Materiaux'), 
    (3, 'Argent'); 

INSERT INTO Besoin_Fille (id_Besoin_Fille, id_Besoin_Categorie, prix_Unitaire) VALUES
    (1, 1, 5.00),
    (2, 1, 1.00),
    (3, 2, 15.00),
    (4, 3, 100.00);

INSERT INTO Besoin (id_Besoin, id_Ville, id_Besoin_Fille, quantite, nom_Besoin) VALUES
    (1, 1, 1, 100.0, 'Riz'),     -- Nature: riz
    (2, 2, 2, 200.0, 'Huile'),   -- Nature: huile
    (3, 3, 3, 50.0, 'Tole'),     -- Materiaux: tôle
    (4, 4, 4, 10.0, 'Argent');   -- Argent: fonds

INSERT INTO Don (id_Don, id_Besoin_Fille, date_Dispatch, quantite) VALUES
    (1, 1, '2026-02-10', 200.0),
    (2, 3, '2026-02-12', 200.0),
    (3, 4, '2026-02-15', 200.0);

-- Fin des donnees de test

DROP VIEW IF EXISTS V_Besoin;
CREATE VIEW V_Besoin AS
SELECT
    bc.id_Besoin_Categorie AS id_Besoin_Categorie,
    bc.libelle AS categorie_libelle,
    bf.id_Besoin_Fille AS id_Besoin_Fille,
    bf.prix_Unitaire AS prix_Unitaire,
    b.id_Besoin AS id_Besoin,
    b.id_Ville AS id_Ville,
    b.quantite AS quantite,
    b.nom_Besoin AS nom_Besoin
FROM Besoin b
JOIN Besoin_Fille bf ON b.id_Besoin_Fille = bf.id_Besoin_Fille
JOIN Besoin_Categorie bc ON bf.id_Besoin_Categorie = bc.id_Besoin_Categorie;


DROP VIEW IF EXISTS V_DonParVille;
CREATE VIEW V_DonParVille AS
SELECT
    d.id_Don AS id_Don,
    d.id_Besoin_Fille AS id_Besoin_Fille,
    d.quantite AS quantite_don,
    d.date_Dispatch AS date_dispatch,
    bc.libelle AS categorie_libelle,
    bf.prix_Unitaire AS prix_unitaire,
    (SELECT b.nom_Besoin FROM Besoin b 
     WHERE b.id_Besoin_Fille = d.id_Besoin_Fille 
     AND b.id_Ville = d.id_Ville LIMIT 1) AS nom_produit,
    d.id_Ville AS id_Ville,
    v.nom_Ville AS nom_Ville,
    r.nom_Region AS nom_Region
FROM Don d
LEFT JOIN Besoin_Fille bf ON d.id_Besoin_Fille = bf.id_Besoin_Fille
LEFT JOIN Besoin_Categorie bc ON bf.id_Besoin_Categorie = bc.id_Besoin_Categorie
LEFT JOIN Ville v ON d.id_Ville = v.id_Ville
LEFT JOIN Region r ON v.id_Region = r.id_Region
ORDER BY d.date_Dispatch DESC;


DROP VIEW IF EXISTS V_AchatAttente;
CREATE VIEW V_AchatAttente AS
SELECT
    aa.id_Achat_Attente AS id_Achat_Attente,
    COALESCE(b.nom_Besoin, '') AS nom_produit,
    aa.quantite AS quantite,
    bf.prix_Unitaire AS prix_unitaire,
    (aa.quantite * bf.prix_Unitaire) AS prix_total,
    aa.date_dispatch AS date_dispatch
FROM Achat_Attente aa
LEFT JOIN Besoin b ON aa.id_Besoin = b.id_Besoin
LEFT JOIN Besoin_Fille bf ON b.id_Besoin_Fille = bf.id_Besoin_Fille;

DROP VIEW IF EXISTS V_BesoinSimulation;
CREATE VIEW V_BesoinSimulation AS
SELECT
    b.id_Besoin AS id_Besoin,
    b.nom_Besoin AS nom_Besoin,
    b.quantite AS quantite_actuelle,
    bf.prix_Unitaire AS prix_unitaire,
    COALESCE(aa.total_attente, 0) AS simulate_qte,
    GREATEST(b.quantite - COALESCE(aa.total_attente, 0), 0) AS quantite_apres,
    (COALESCE(aa.total_attente, 0) * bf.prix_Unitaire) AS prix_total
FROM Besoin b
LEFT JOIN Besoin_Fille bf ON b.id_Besoin_Fille = bf.id_Besoin_Fille
LEFT JOIN (
    SELECT id_Besoin, id_Achat_Attente, SUM(quantite) AS total_attente
    FROM Achat_Attente
    GROUP BY id_Besoin
) aa ON aa.id_Besoin = b.id_Besoin;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Achat_Fille;
CREATE TABLE Achat_Fille(
    id_Achat_Fille int primary key auto_increment,
    id_Besoin_Categorie int references Besoin_Categorie(id_Besoin_Categorie),
    frais_Pourcentage double
); 

DROP TABLE IF EXISTS Achat;
CREATE TABLE Achat(
    id_Achat int primary key auto_increment,
    id_Besoin int references Besoin(id_Besoin),
    id_Don int references Don(id_Don),
    quantite double,
    montant double,
    date date
);

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO Achat_Fille (id_Besoin_Categorie, frais_Pourcentage) VALUES
(1, 2.5),
(2, 1.75),
(3, 3.0);

INSERT INTO Achat (id_Besoin, id_Don, quantite, montant) VALUES
(1, 1, 5, 12.50),
(2, 2, 10, 24.00),
(3, 3, 2, 0.00),
(1, 4, 1, 5.00),
(2, 5, 7, 16.80);

INSERT INTO Achat_Attente (id_Achat_Attente, id_Ville, id_Besoin, quantite, date_dispatch, prix) VALUES
    (1, 1, 1, 20.0, '2026-02-11', 50.00),
    (2, 2, 2, 15.0, '2026-02-13', 22.50),
    (3, 3, 3, 5.0,  '2026-02-14', 75.00),
    (4, 4, 4, 2.0,  '2026-02-16', 200.00),
    (5, 1, 2, 30.0, '2026-02-18', 45.00);

    INSERT INTO Besoin (id_Besoin, id_Ville, id_Besoin_Fille, quantite, nom_Besoin) VALUES
    (5, 2, 1, 150.0, 'Riz'),     
    (6, 4, 2, 10.0, 'Huile'),  
    (7, 1, 3, 20.0, 'Tole'),    
    (8, 3, 4, 50.0, 'Argent');   
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return 1;
    }

}