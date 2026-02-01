FROM php:8.1-fpm

# UID/GIDを引数で受け取る
ARG UID=1000
ARG GID=1000

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# www-dataのUID/GIDをホストに合わせる
RUN usermod -u $UID www-data && groupmod -g $GID www-data

WORKDIR /var/www

# www-dataユーザーで実行
USER www-data