FROM php:8.2-apache-bookworm

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite
COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY config.json /var/www/html/config.json

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html