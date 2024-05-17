# Utiliser une image officielle PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql mbstring xml

# Installer Composer
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Configurer le document root d'Apache pour Symfony
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

# Copier le code de l'application
COPY . /var/www/html

# Configurer les droits
RUN chown -R www-data:www-data /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80
