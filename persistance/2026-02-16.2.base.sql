CREATE OR REPLACE TABLE Achat_Fille(
    id_Achat_Fille int primary key auto_increment,
    id_Besoin_Categorie int references Besoin_Categorie(id_Besoin_Categorie),
    frais_Pourcentage double
); 

CREATE OR REPLACE TABLE Achat(
    id_Achat int primary key auto_increment,
    id_Besoin int references Besoin(id_Besoin),
    id_Don int references Don(id_Don),
    quantite double,
    montant double
);