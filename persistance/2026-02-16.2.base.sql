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