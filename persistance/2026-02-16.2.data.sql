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
