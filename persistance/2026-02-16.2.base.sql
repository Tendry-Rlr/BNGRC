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

CREATE OR REPLACE TABLE Achat_Entente(
    id_Achat_Entente int primary key auto_increment,
    id_Achat int references Achat(id_Achat),
    partenaire varchar(100),
    montant_entente double,
    date_entente date
);