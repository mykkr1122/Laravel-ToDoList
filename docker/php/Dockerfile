FROM php:8.0-fpm
COPY php.ini /usr/local/etc/php

# package & library install
# RUN apt-get update \
#     && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
#     && docker-php-ext-install zip pdo_mysql \
#     && apt-get install -y procps

RUN apt-get update && apt-get install -y libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install gd zip

RUN docker-php-ext-install pdo_mysql


# composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer


ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH: /composer/vendor/bin

# laravel package install
RUN composer global require "laravel/installer"

# 作業ディレクトリの指定
WORKDIR /var/www


