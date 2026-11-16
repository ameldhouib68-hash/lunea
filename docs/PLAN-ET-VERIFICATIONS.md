# Plan et critères de réussite
État : préparation des fichiers. Aucune installation Mac, boutique opérationnelle ou publication GitHub n’a été vérifiée.

1. Recevoir les captures de référence et confirmer macOS, puce et éventuel XAMPP existant.
2. Installer XAMPP natif sur le Mac, démarrer Apache et MariaDB, ouvrir localhost. Ne pas utiliser XAMPP-VM sur Apple Silicon. Vérifier les extensions PHP et 512M de mémoire ; résoudre les erreurs exactes sans désactiver globalement la sécurité macOS. Rosetta peut être nécessaire pour les composants Intel.
3. Créer lunea via phpMyAdmin. SQL est le langage ; MariaDB est le moteur ; phpMyAdmin est son interface. PrestaShop enregistrera produits, stocks, clients et commandes dans ses tables.
4. Installer une distribution officielle PrestaShop 9 compatible avec PHP 8.2 sous /Applications/XAMPP/xamppfiles/htdocs/lunea. Vérifier la version corrective au moment du téléchargement. Configurer français, France et EUR, créer les identifiants localement, supprimer le dossier install à la fin. Ne jamais partager le mot de passe administrateur.
5. Installer le module LUNÉA, adapter le thème réel installé (Classic ou Hummingbird selon la distribution), intégrer les images après examen des références, importer le catalogue et les déclinaisons. Désactiver les produits exemple de PrestaShop après vérification.
6. Créer Notre maison et une catégorie CMS Le journal contenant les quatre articles. Configurer menu, pied de page, produits phares et module de recherche à facettes avec prix/couleurs/types. Tester l’indexation.
7. Configurer le formulaire de contact et les champs prénom/nom. Vérifier l’enregistrement et/ou la réception avec un dispositif mail de test. XAMPP seul ne garantit pas l’envoi d’e-mails. Tester la newsletter avec une adresse fictive.
8. Configurer le transporteur de test. Pour le paiement : méthode hors ligne clairement désignée « commande de démonstration », sans coordonnées bancaires réelles. Aucun module de paiement réel activé. Vérifier panier, quantités, suppression, compte, adresse, commande et baisse du stock.
9. Vérifier les tailles 390, 768 et 1440 pixels, clavier, erreurs de formulaire et produits épuisés.
10. Versionner uniquement les sources utiles. Créer lunea-ecommerce sur GitHub avec une connexion autorisée. Vérifier la liste des fichiers avant tout push. Le .gitignore ne retire pas les secrets déjà suivis.
11. Préparer une base dédiée sans clients réels, messages, employés ou secrets. Produire un vrai export SQL assaini et tester sa restauration ; aucun dump brut ne doit être publié. La reconstruction par import dans une installation neuve évite de diffuser les identifiants de configuration.
12. Insérer les captures réellement obtenues dans le dossier de rendu et remplacer les statuts « à vérifier » par les résultats constatés.

## Recette d’achat
Utiliser uniquement des identités de démonstration. Ajouter 2 Aube sable, contrôler 178 € de produits ; vérifier la livraison offerte au-dessus de 100 €. Passer à 1 Aube : 89 € + 4,90 € de livraison = 93,90 € dans le scénario prévu. Supprimer le produit : panier vide. Recommencer, créer le compte de test, choisir une adresse de démonstration, passer la commande hors ligne. Vérifier son numéro, son statut, ses lignes et le stock de la déclinaison. Les prix doivent être affichés TTC et la règle de taxe contrôlée.

## Sources consultées le 16 novembre 2026
- https://devdocs.prestashop-project.org/9/basics/installation/system-requirements/
- https://www.apachefriends.org/download.html
- https://www.apachefriends.org/faq_stackman.html
- https://devdocs.prestashop-project.org/9/themes/
XAMPP macOS propose PHP 8.2.4 : compatible en version majeure avec PrestaShop 9, mais ancienne révision. Usage strictement local ; ne pas exposer cette pile sur Internet. Les correctifs et la compatibilité réelle doivent être contrôlés sur le Mac.
