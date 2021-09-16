FROM composer:2.1.6 AS composer
FROM php:8.0.10-apache-buster

# Install dependencies
# hadolint ignore=DL3008,DL3015
RUN apt-get update && apt-get install -y \
      zip \
      unzip

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set timezone
RUN ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime

# Copy PHP configuration: MUST be done before to install PHP extensions
COPY ./docker/config/php.ini-production $PHP_INI_DIR/php.ini

# Install php extensions
RUN pecl install -f xdebug-3.0.4 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql opcache

# Set Apache configuration
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache module
RUN a2enmod rewrite

WORKDIR /var/www/html

