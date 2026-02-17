USE BNGRC;

SELECT '=== TEST ACTUALISATION ===' AS '';
SELECT 'Avant modification:' AS '', COALESCE(SUM(prix_Unitaire * quantite), 0) AS montant_besoins FROM V_Besoin WHERE quantite > 0;

UPDATE Besoin SET quantite = quantite + 10 WHERE id_Besoin = 1;
SELECT 'Après +10 unités sur Riz:' AS '', COALESCE(SUM(prix_Unitaire * quantite), 0) AS montant_besoins FROM V_Besoin WHERE quantite > 0;
SELECT 'Attendu: +50 Ar (10 * 5)' AS '';
SELECT 'Maintenant cliquez sur Actualiser dans le navigateur' AS '';

SELECT 'Attendez 5 secondes puis annuler...' AS '';
DO SLEEP(5);

UPDATE Besoin SET quantite = quantite - 10 WHERE id_Besoin = 1;
SELECT 'Modification annulée' AS '', COALESCE(SUM(prix_Unitaire * quantite), 0) AS montant_besoins FROM V_Besoin WHERE quantite > 0;
