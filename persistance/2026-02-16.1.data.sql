-- Donnees de test
INSERT INTO Region (id_Region, nom_Region) VALUES
    (1, 'Nord', 200.0),
    (2, 'Sud'), 200.0,
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