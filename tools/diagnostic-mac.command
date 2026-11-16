#!/bin/bash
# Lecture seule : aucun mot de passe, aucune configuration secrète affichée.
printf '=== macOS ===\n'
sw_vers -productVersion
printf '\n=== Architecture du processus ===\n'
uname -m
printf '\n=== Git ===\n'
if xcode-select -p >/dev/null 2>&1; then git --version; else printf 'Outils Apple non détectés (Git à vérifier).\n'; fi
printf '\n=== PHP XAMPP ===\n'
if [ -x /Applications/XAMPP/xamppfiles/bin/php ]; then
 /Applications/XAMPP/xamppfiles/bin/php -v
 /Applications/XAMPP/xamppfiles/bin/php -r 'foreach (["curl","dom","fileinfo","gd","iconv","intl","json","mbstring","openssl","pdo_mysql","SimpleXML","zip"] as $e) {echo $e.": ".(extension_loaded($e)?"OK":"MANQUANT").PHP_EOL;} echo "memory_limit=".ini_get("memory_limit").PHP_EOL;'
else printf 'XAMPP non détecté à son emplacement habituel.\n'; fi
