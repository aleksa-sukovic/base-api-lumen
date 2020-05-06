FROM php:7.2-apache

LABEL maintainer="Aleksa Sukovic"

ARG USER_ID
ARG USER_GROUP

# PHP and Apache configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install \
   mysqli \
   pdo \
   pdo_mysql
RUN ["a2enmod", "rewrite", "negotiation"]

# Install packages
RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y \
    zip \
    unzip \
    wget \
    vim \
    nano

# Source and Configuration
COPY ./ /var/www/html/
COPY ./.docker/config/apache-host.conf /etc/apache2/sites-available/000-default.conf

# Composer
RUN chmod +x /var/www/html/.docker/scripts/composer-install.sh
RUN /var/www/html/.docker/scripts/composer-install.sh \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Changing user group
RUN groupmod --gid $USER_GROUP www-data
RUN usermod --uid $USER_ID www-data

EXPOSE 80
