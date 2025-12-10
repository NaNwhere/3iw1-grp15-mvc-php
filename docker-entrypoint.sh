#!/bin/bash
set -e

# Vérifie si le dossier vendor existe
if [ ! -d "vendor" ]; then
    echo "Dossier vendor introuvable. Installation des dépendances..."
    composer install --no-interaction --optimize-autoloader
else
    echo "Dossier vendor présent."
fi

# Exécute la commande passée en argument au conteneur (ex: apache2-foreground)
exec "$@"
