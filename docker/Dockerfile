FROM php:8.1-fpm

ARG USER
ARG USER_ID
ARG GROUP_ID

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    vim \
    libicu-dev
#    php-curl \
#    php-mbstring \

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash \
    && apt-get install nodejs -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl





RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get install libcurl4-openssl-dev
RUN apt-get install libonig-dev
RUN docker-php-ext-install curl
#RUN pecl install php-curl \
#    && docker-php-ext-enable php-curl

RUN docker-php-ext-install mbstring
#RUN pecl install php-mbstring \
#    && docker-php-ext-enable php-mbstring

COPY xdebug.ini "${PHP_INI_DIR}/conf.d"
#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug
#COPY xdebug.ini "${PHP_INI_DIR}/conf.d"


RUN groupadd --force -g $GROUP_ID $USER
RUN useradd -ms /bin/bash --no-user-group -g $GROUP_ID -u 1337 $USER
RUN usermod -u $USER_ID $USER

USER $USER
