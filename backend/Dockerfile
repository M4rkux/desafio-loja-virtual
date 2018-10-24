FROM php:7.2.2-apache as builder

RUN docker-php-ext-install pdo_mysql \ 
    && docker-php-ext-enable pdo_mysql \
    && a2enmod rewrite \
    && service apache2 restart