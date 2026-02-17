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
    (1, 'Atsinanana'),
    (2, 'Vatovavy-Fitovinany'),
    (3, 'Atsimo-Atsinanana'),
    (4, 'Diana'),
    (5, 'Menabe');

INSERT INTO Ville (id_Ville, id_Region, nom_Ville) VALUES
    (1, 1, 'Toamasina'),
    (2, 2, 'Mananjary'),
    (3, 3, 'Farafangana'),
    (4, 4, 'Nosy Be'),
    (5, 5, 'Morondava');

INSERT INTO Besoin_Categorie (id_Besoin_Categorie, libelle) VALUES
    (1, 'nature'),
    (2, 'materiel'),
    (3, 'argent');

INSERT INTO Besoin_Fille (id_Besoin_Fille, id_Besoin_Categorie, prix_Unitaire) VALUES
    (1, 1, 3000),    -- Riz (kg)
    (2, 1, 1000),    -- Eau (L)
    (3, 1, 6000),    -- Huile (L)
    (4, 1, 4000),    -- Haricots
    (5, 2, 25000),   -- Tôle
    (6, 2, 15000),   -- Bâche
    (7, 2, 8000),    -- Clous (kg)
    (8, 2, 10000),   -- Bois
    (9, 2, 6750000), -- Groupe
    (10, 3, 1);      -- Argent

-- Besoins ordonnes par colonne Ordre
INSERT INTO Besoin (id_Besoin, id_Ville, id_Besoin_Fille, quantite, nom_Besoin) VALUES
    (1,  1, 6, 200,      'Bache'),         -- Ordre 1  Toamasina
    (2,  4, 5, 40,       'Tole'),          -- Ordre 2  Nosy Be
    (3,  2, 10, 6000000, 'Argent'),        -- Ordre 3  Mananjary
    (4,  1, 2, 1500,     'Eau (L)'),       -- Ordre 4  Toamasina
    (5,  4, 1, 300,      'Riz (kg)'),      -- Ordre 5  Nosy Be
    (6,  2, 5, 80,       'Tole'),          -- Ordre 6  Mananjary
    (7,  4, 10, 4000000, 'Argent'),        -- Ordre 7  Nosy Be
    (8,  3, 6, 150,      'Bache'),         -- Ordre 8  Farafangana
    (9,  2, 1, 500,      'Riz (kg)'),      -- Ordre 9  Mananjary
    (10, 3, 10, 8000000, 'Argent'),        -- Ordre 10 Farafangana
    (11, 5, 1, 700,      'Riz (kg)'),      -- Ordre 11 Morondava
    (12, 1, 10, 12000000,'Argent'),        -- Ordre 12 Toamasina
    (13, 5, 10, 10000000,'Argent'),        -- Ordre 13 Morondava
    (14, 3, 2, 1000,     'Eau (L)'),       -- Ordre 14 Farafangana
    (15, 5, 6, 180,      'Bache'),         -- Ordre 15 Morondava
    (16, 1, 9, 3,        'Groupe'),        -- Ordre 16 Toamasina
    (17, 1, 1, 800,      'Riz (kg)'),      -- Ordre 17 Toamasina
    (18, 4, 4, 200,      'Haricots'),      -- Ordre 18 Nosy Be
    (19, 2, 7, 60,       'Clous (kg)'),    -- Ordre 19 Mananjary
    (20, 5, 2, 1200,     'Eau (L)'),       -- Ordre 20 Morondava
    (21, 3, 1, 600,      'Riz (kg)'),      -- Ordre 21 Farafangana
    (22, 5, 8, 150,      'Bois'),          -- Ordre 22 Morondava
    (23, 1, 5, 120,      'Tole'),          -- Ordre 23 Toamasina
    (24, 4, 7, 30,       'Clous (kg)'),    -- Ordre 24 Nosy Be
    (25, 2, 3, 120,      'Huile (L)'),     -- Ordre 25 Mananjary
    (26, 3, 8, 100,      'Bois');          -- Ordre 26 Farafangana

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
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return 1;
    }

}