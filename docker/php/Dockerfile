FROM php:8.3-fpm

RUN apt update \
    && apt install -y libpq-dev zlib1g-dev g++ git libicu-dev zip libzip-dev \
    && docker-php-ext-install intl opcache pdo_pgsql pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

## uncomment if you need xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer
