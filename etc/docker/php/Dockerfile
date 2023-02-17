################################################################
# Base PRODUCTION image
# Inspired by https://github.com/webdevops/Dockerfile/blob/master/docker/php-official/8.1-alpine/Dockerfile
################################################################

FROM php:8.1-fpm-alpine3.17 as php-base

ENV TERM="xterm" \
    LANG="C.UTF-8" \
    LC_ALL="C.UTF-8"

###
### User/Group
###

RUN apk add --no-cache \
    bash \
    make \
    curl \
    git \
    patch \
    imagemagick \
    graphicsmagick \
    ghostscript \
    jpegoptim \
    pngcrush \
    optipng \
    pngquant \
    vips \
    c-client \
    # Libraries
    icu-libs \
    libintl \
    libpq \
    libzip \
    yaml \
    # Build dependencies
    linux-headers \
    autoconf \
    g++ \
    make \
    libtool \
    pcre-dev \
    gettext-dev \
    freetype-dev \
    gmp-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    vips-dev \
    krb5-dev \
    openssl-dev \
    imap-dev \
    imagemagick-dev \
    icu-dev \
    libxml2-dev \
    ldb-dev \
    pcre-dev \
    libzip-dev \
    yaml-dev \
  # Install extensions
     && PKG_CONFIG_PATH=/usr/local docker-php-ext-configure intl \
     && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
     && PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
     && docker-php-ext-install \
         bcmath \
         bz2 \
         calendar \
         exif \
         ffi \
         intl \
         gettext \
         mysqli \
         pdo_mysql \
         sockets \
         zip \
         gd \
         gettext \
         opcache \
     && pecl install redis \
     && pecl install apcu \
     && pecl install yaml \
     && pecl install xdebug \
     && docker-php-ext-enable \
         apcu \
         yaml \
         redis \
         xdebug \
     # Uninstall dev and header packages
     && apk del -f --purge \
         autoconf \
         linux-headers \
         g++ \
         libtool \
         pcre-dev \
         gettext-dev \
         freetype-dev \
         gmp-dev \
         libjpeg-turbo-dev \
         libpng-dev \
         vips-dev \
         krb5-dev \
         openssl-dev \
         imap-dev \
         imagemagick-dev \
         icu-dev \
         libxml2-dev \
         ldb-dev \
         pcre-dev \
         libzip-dev \
         yaml-dev \
     && rm -f /usr/local/etc/php-fpm.d/zz-docker.conf \
     && mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled \
     && echo "xdebug.discover_client_host=On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled \
     && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled \
     && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled \
     && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled \
     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
     && echo "Europe/Amsterdam" >  /etc/timezone

COPY ./etc/docker/config/php.ini /usr/local/etc/php/conf.d/xxx-growthbase-default-php.ini
COPY ./etc/docker/config/php-fpm.conf /usr/local/etc/php-fpm.conf

EXPOSE 9000

WORKDIR /app

################################################################
# Base TEST image.
#
# With all test required dependencies.
# - xdebug
# - composer
################################################################

FROM php-base as base

# Set the workdir to improve QOL for "docker compose exec" commands e.g. "bin/console" can be used relatively, as we're
# used to.
WORKDIR /app

################################################################
# DEVELOPMENT
################################################################

FROM base AS development

# This is for docker compose integration for yetbrains IDE, you cannot specify the user
# during a connection
USER www-data
