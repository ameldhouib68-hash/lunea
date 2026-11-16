-- DONNÉES DE PRÉPARATION, PAS UN EXPORT PRESTASHOP.
-- Table pédagogique indépendante. Ne recrée ni panier ni commandes PrestaShop.
CREATE TABLE IF NOT EXISTS lunea_catalogue_demo (
 reference VARCHAR(24) PRIMARY KEY,
 nom VARCHAR(80) NOT NULL,
 prix_ttc_eur DECIMAL(10,2) NOT NULL,
 description TEXT NOT NULL
);
INSERT INTO lunea_catalogue_demo VALUES ('LUN-001','Aube',89,'Une lumière ambrée, un volume délicat, une présence chaleureuse. Aube habille une table de chevet de sa céramique mate et accompagne les moments calmes de la soirée.') ON DUPLICATE KEY UPDATE nom=VALUES(nom), prix_ttc_eur=VALUES(prix_ttc_eur), description=VALUES(description);
INSERT INTO lunea_catalogue_demo VALUES ('LUN-002','Halo',69,'Avec ses lignes arrondies, Halo trouve naturellement sa place près du lit. Son intensité réglable permet de passer d’une ambiance accueillante à une lueur discrète.') ON DUPLICATE KEY UPDATE nom=VALUES(nom), prix_ttc_eur=VALUES(prix_ttc_eur), description=VALUES(description);
INSERT INTO lunea_catalogue_demo VALUES ('LUN-003','Sora',79,'Inspirée des formes naturelles, Sora apporte une touche de douceur au quotidien. Sa céramique et ses trois niveaux de lumière composent une atmosphère calme, du salon à la chambre.') ON DUPLICATE KEY UPDATE nom=VALUES(nom), prix_ttc_eur=VALUES(prix_ttc_eur), description=VALUES(description);
INSERT INTO lunea_catalogue_demo VALUES ('LUN-004','Nacre',59,'Petite par sa taille, précieuse par sa présence : Nacre éclaire une étagère ou un coin de chambre d’une lueur délicate. Son diffuseur adoucit la lumière pour une décoration tout en légèreté.') ON DUPLICATE KEY UPDATE nom=VALUES(nom), prix_ttc_eur=VALUES(prix_ttc_eur), description=VALUES(description);
INSERT INTO lunea_catalogue_demo VALUES ('LUN-005','Éclipse',99,'Éclipse se distingue par sa silhouette sculpturale. Sa lumière indirecte souligne ses courbes et donne du caractère à une console ou à une table basse, sans dominer la pièce.') ON DUPLICATE KEY UPDATE nom=VALUES(nom), prix_ttc_eur=VALUES(prix_ttc_eur), description=VALUES(description);
INSERT INTO lunea_catalogue_demo VALUES ('LUN-006','Brume',49,'Compacte et facile à déplacer, Brume accompagne vos pauses du soir. Son dessin épuré et sa lumière diffuse en font un petit objet familier, à poser là où vous aimez vous détendre.') ON DUPLICATE KEY UPDATE nom=VALUES(nom), prix_ttc_eur=VALUES(prix_ttc_eur), description=VALUES(description);
