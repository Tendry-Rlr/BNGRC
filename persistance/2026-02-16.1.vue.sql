CREATE OR REPLACE VIEW V_Besoin AS
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

CREATE OR REPLACE VIEW V_DonParVille AS
SELECT
    d.id_Don AS id_Don,
    d.id_Besoin_Fille AS id_Besoin_Fille,
    d.quantite AS quantite_don,
    d.date_Dispatch AS date_dispatch,
    bc.libelle AS categorie_libelle,
    bf.prix_Unitaire AS prix_unitaire,
    b.nom_Besoin AS nom_produit,
    b.id_Ville AS id_Ville,
    v.nom_Ville AS nom_Ville,
    r.nom_Region AS nom_Region
FROM Don d
LEFT JOIN Besoin_Fille bf ON d.id_Besoin_Fille = bf.id_Besoin_Fille
LEFT JOIN Besoin b ON bf.id_Besoin_Fille = b.id_Besoin_Fille
LEFT JOIN Besoin_Categorie bc ON bf.id_Besoin_Categorie = bc.id_Besoin_Categorie
LEFT JOIN Ville v ON b.id_Ville = v.id_Ville
LEFT JOIN Region r ON v.id_Region = r.id_Region
ORDER BY d.date_Dispatch DESC;

select * from V_DonParVille;
select * from V_Besoin;