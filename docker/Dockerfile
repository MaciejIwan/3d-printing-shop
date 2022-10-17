FROM php:8.1.12RC1-fpm-alpine3.16
#FROM php:8.0.2-fpm

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && apk del pcre-dev ${PHPIZE_DEPS}
