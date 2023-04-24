# docker/php/Dockerfile
FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y openssl zip unzip git curl
RUN apt-get install -y libzip-dev libonig-dev libicu-dev
RUN apt-get install -y autoconf pkg-config libssl-dev
RUN docker-php-ext-install bcmath mbstring intl opcache

RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini
RUN apt-get remove -y python3.9-minimal
# RUN apt-get install -y python3.9-minimal

# RUN apt-get install -y nodejs npm

# RUN  apt-get install -y npm
# FROM node:18-alpine







