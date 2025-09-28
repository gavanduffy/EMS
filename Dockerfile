# syntax=docker/dockerfile:1.4

FROM composer:2 AS vendor
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN set -eux; \
    if command -v apt-get >/dev/null; then \
        apt-get update; \
        apt-get install -y --no-install-recommends \
            libjpeg62-turbo-dev \
            libpng-dev \
            libfreetype6-dev \
            libicu-dev \
            libsodium-dev; \
    elif command -v apk >/dev/null; then \
        apk add --no-cache \
            libjpeg-turbo-dev \
            libpng-dev \
            freetype-dev \
            icu-dev \
            libsodium-dev; \
    else \
        echo "Unsupported package manager" >&2; \
        exit 1; \
    fi; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" \
        exif \
        gd \
        intl \
        sodium; \
    if command -v apt-get >/dev/null; then \
        rm -rf /var/lib/apt/lists/*; \
    else \
        rm -rf /var/cache/apk/*; \
    fi

COPY composer.json composer.lock* ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

FROM node:20 AS frontend
WORKDIR /var/www/html

COPY package.json package-lock.json* ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY webpack.mix.js ./
COPY tailwind.config.js ./
RUN npm run production

FROM php:8.2-apache AS production

ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libssl-dev \
        libbz2-dev \
        curl \
        gosu \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        pcntl \
        pdo_mysql \
        pdo_pgsql \
        zip \
    && docker-php-ext-enable opcache \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite headers

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY --from=vendor /var/www/html /var/www/html
COPY --from=frontend /var/www/html/public /var/www/html/public

COPY docker/entrypoint.sh /usr/local/bin/app-entrypoint
RUN chmod +x /usr/local/bin/app-entrypoint

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["app-entrypoint"]
CMD ["apache2-foreground"]
