ARG DOCKER_PHP_VERSION

FROM php:8.2-fpm-alpine

ARG TZ='UTC'

# https://wiki.alpinelinux.org/wiki/Setting_the_timezone
RUN echo "${TZ}" && apk --update add tzdata && \
    cp /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone

RUN apk add --no-cache libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN /usr/local/bin/composer self-update

USER www-data:www-data

WORKDIR /var/www/
