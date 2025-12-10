# Utilise l'image officielle PHP + Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires pour PostgreSQL et activer modules
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    unzip \
    libyaml-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

# Installation de l'extension YAML via PECL
RUN pecl install yaml && docker-php-ext-enable yaml

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activation du module rewrite d'Apache
RUN a2enmod rewrite

# Configurer le DocumentRoot Apache pour pointer vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copier un php.ini personnalisé si besoin (monté via docker-compose)
# Configurer le répertoire de travail
WORKDIR /var/www/html

# Copie du fichier composer.json pour installation des dépendances
COPY www/composer.json ./

# Installation des dépendances via Composer
RUN composer install --no-dev --optimize-autoloader

# Copie du script d'entrypoint pour installer les dépendances au démarrage
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Permettre à Apache d'écrire sur le dossier (utile pour uploads / sessions)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
