# Použijeme oficiální image s PHP 8.3 a Apache
FROM php:8.3-apache

# Zapnutí Apache modulu mod_rewrite
# Nutné pro fungování .htaccess a přepis URL
RUN a2enmod rewrite

# Úprava Apache konfigurace
# Defaultně je AllowOverride None → .htaccess by se ignoroval
# Přepínáme na AllowOverride All → Apache bude .htaccess respektovat
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Instalace rozšíření pro PDO a MySQL
# PDO (PHP Data Objects) je rozhraní pro přístup k databázím v PHP
# pdo_mysql je konkrétní driver pro MySQL databáze
RUN docker-php-ext-install pdo pdo_mysql